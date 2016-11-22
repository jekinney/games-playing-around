<?php

namespace App\Games\Models;

use App\Events\GameHasEnded;
use App\Games\Traits\RedisDatastore;

class BlackJack 
{
	use RedisDatastore;
	/**
	* Startgame set up
	* 
	* @param integer $bet
	* @return object $gamedata
	*/
	public function start($bet, $redisKey = null)
	{
		$redisKey = $this->setDeck('blackjack', $redisKey);
		$playersHand = $this->setPlayersHand($redisKey, 2);
		$dealersHand = $this->setDealersHand($redisKey, 2);
		if($playersHand['meta'] && $playersHand['meta']['gameover'] == true) {
			event(new GameHasEnded($redisKey, $playersHand['meta']));
		}
		return ['game' => $redisKey, 'player' => $playersHand, 'dealer' => $dealersHand];
	}

	/**
	* Player takes a hit (Wants a card)
	* Card is taken from game deck, removed from deck and merged with current hand
	*
	* @param string $redisKey
	* @param string $userId
	* @return object $hand
	*/
	public function hit($redisKey)
	{
		$playerHand = $this->setPlayersHand($redisKey);
		if($playerHand['meta'] && $playerHand['meta']['gameover'] == true) {
			event(new GameHasEnded($redisKey, $playerHand['meta']));
		}
		return $playerHand;
	}

	/**
	* Player stays and now is the dealers turn.
	* Card is taken from game deck, removed from deck and merged with current hand
	*
	* @param string $redisKey
	* @param string $userId
	* @return object $hand
	*/
	public function stay($redisKey)
	{
		$dealerHand = $this->setDealersHand($redisKey);
		if($dealerHand['meta'] && $dealerHand['meta']['gameover'] == true) {
			event(new GameHasEnded($redisKey, $dealerHand['meta']));
		}
		return $dealerHand;
	}

	/**
	* Takes cards from the game deck, removes them from the deck and 
	* sets hand into redis
	*
	* @param string $redisKey
	* @param integer $amount (number of random cards)
	* @return object $hand
	*/
	protected function setPlayersHand($redisKey, $amount = 1)
	{
		if($this->getHand($redisKey.'.player')) {
			$cards = $this->pushToHand($redisKey.'.player', $redisKey);
		} else {
			$cards = $this->getCardsFromDeck($redisKey, $amount);
		}
		return $this->setHandMeta($cards, $redisKey);
	}

	/**
	* Takes cards from the game deck, removes them from the deck and 
	* sets hand into redis
	*
	* @param string $redisKey
	* @param integer $amount (number of random cards)
	* @return object $hand
	*/
	protected function setDealersHand($redisKey, $amount = 1)
	{
		$currentHand = $this->getHand($redisKey.'.dealer');
		if($currentHand) {
			if($currentHand['meta']['base_total'] > 17 || $currentHand['meta']['alt_total'] > 17) {
				return $this->decideWinner($currentHand, $redisKey);
			}
			$cards = $this->pushToHand($redisKey.'.dealer', $redisKey);
		} else {
			$cards = $this->getCardsFromDeck($redisKey, $amount);
		}
		return $this->setHandMeta($cards, $redisKey, true);
	}

	/**
	* Adding meta data to each hand. Adds up card value, alt value (incase of Ace)
	* adds status message in case 21 or over 21
	* 
	* @param array $cards
	* @return array $hand
	*/
	protected function setHandMeta($cards, $redisKey, $isDealer = false)
	{
		$meta = [
			'base_total' => 0, 
			'alt_total' => null, 
			'dealer' => $isDealer, 
			'status' => 100, 
			'message' => null,
			'title' => null,
			'gameover' => false,
		];
		$meta = $this->setMetaHandTotals($cards, $meta);
		$meta = $this->setMetaStatus($meta);
		$hand = ['hand' => $cards, 'meta' => $meta];
		if($isDealer) {
			return $this->setDealerMeta($hand, $redisKey);
		}
		return $this->setPlayerMeta($hand, $redisKey);
	}

	protected function setDealerMeta(array $hand, $redisKey) 
	{
		$hand = $this->sethand($redisKey.'.dealer', $hand);
		$cards = $hand['hand'];
		if($hand['round'] == 1) {
			$cards = array_splice($hand['hand'], 1, count($hand['hand']));
			$dealersHand['hand'][] = ['image' => '/images/cards/playing-card-back.jpg'];
		} elseif($hand['round'] > 1) {
			$dealersHand['meta'] = $hand['meta'];
			$dealersHand['meta']['round'] = $hand['round'];
		}
		foreach($cards as $card) {
			$dealersHand['hand'][] = ['image' => $card['image']];
		}
		return $dealersHand;
	}

	protected function setPlayerMeta(array $hand, $redisKey)
	{
		return $this->sethand($redisKey.'.player', $hand);
	}

	protected function setMetaHandTotals(array $hand, array $meta)
	{
		foreach($hand as $card) {
			$meta['base_total'] = $meta['base_total'] + $card['value'];
			$meta['alt_total'] = $meta['alt_total'] + $card['alt_value'];
		}
		return $meta;
	}

	protected function setMetaStatus(array $meta)
	{
		if($meta['base_total'] > 21) {
			$meta['status'] = 200;
			$meta['title'] = $meta['dealer'] ? 'You Win':'You Lose';
			$meta['message'] = $meta['dealer'] ? 'Dealer went Bust (over 21)':'You went bust! (over 21)';
			$meta['gameover'] = true;
		} elseif($meta['base_total'] == 21 || $meta['alt_total'] == 21) {
			$meta['status'] = 300;
			$meta['title'] = $meta['dealer'] ? 'You Lose':'You Win';
			$meta['message'] = $meta['dealer'] ? 'Dealer Has BlackJack':'You have BlackJack!!';
			$meta['gameover'] = true;
		}
		return $meta;
	}

	protected function decideWinner($dealersHand, $redisKey)
	{
		$playersHand = $this->getHand($redisKey.'.player');
		$player = $playersHand['meta'];
		$dealer = $dealersHand['meta'];
		$dTotal	= $dealer['base_total'];
			if($dTotal <  $dealer['alt_total'] && $dealer['alt_total'] < 22) {
				$dTotal = $dealer['alt_total'];
			}
			$pTotal	= $player['base_total'];
			if($pTotal <  $player['alt_total'] && $player['alt_total'] < 22) {
				$pTotal = $player['alt_total'];
			}
		if($dealer['base_total'] > $player['base_total'] || $dealer['base_total'] > $player['alt_total'] || $dealer['alt_total'] > $player['base_total'] || $dealer['alt_total'] > $player['alt_total']) {
			$results = [
				'gameover' => true, 
				'status' => 400, 
				'dealer' => true,
				'title' => 'Dealer Wins',
				'message' => 
					'Dealer '.$dTotal.' was greater then your '.$pTotal,
				];
		} elseif($dealer['base_total'] < $player['base_total'] || $dealer['base_total'] < $player['alt_total'] || $dealer['alt_total'] < $player['base_total'] || $dealer['alt_total'] < $player['alt_total']) {
			$results = [
				'gameover' => true, 
				'status' => 500, 
				'dealer' => false,
				'title' => 'You Win',
				'message' => 
					'Dealer '.$dealer['base_total'].' was less then your '.$player['base_total'],
				];
		}
		return ['hand' => $dealersHand['hand'], 'meta' => $results];
	}
}