<?php

namespace App\Games\Traits;

use App\Games\Deck\Decks;
use Illuminate\Support\Facades\Redis;

trait RedisDatastore
{
	/**
	* Generate random string with game key (type)
	* 
	* @param string $gameKey
	* @return string $redisKey
	*/
	protected function generateKey($gameType)
	{
		$random = str_random(10);

		return $gameType.'.'.$random;
	}

	/**
	* Set the apprpriate Deck into redis
	* Return the deck as collection
	*
	* @param string $gameType
	* @param string $redisKey
	* @return object $deck, $redisKey
	*/
	protected function setDeck($gameType, $redisKey)
	{
		if($gameType == 'blackjack') {
			$deck = Decks::blackjack();
		} else {
			$deck = Decks::basic();
		}
		if(is_null($redisKey)) {
			$redisKey = $this->generateKey($gameType);
		}
		Redis::set($redisKey.'.deck', $deck);
		return $redisKey;
	}

	/**
	* Update the deck already in redis
	* Return the deck
	*
	* @param string $gameType
	* @param string $redisKey
	* @return object $deck
	*/
	protected function updateDeck($redisKey, array $deck)
	{
		$deck = array_values($deck);
		Redis::set($redisKey.'.deck', json_encode($deck));
		return $deck;
	}

	/**
	* Get the apprpriate Deck into redis
	* Return the deck as collection
	*
	* @param string $gameType
	* @param string $redisKey
	* @return object $deck
	*/
	protected function getDeck($redisKey)
	{
		$deck = Redis::get($redisKey.'.deck');
		return json_decode($deck, true);
	}

	/**
	* Set the apprpriate Deck into redis
	* Return the deck as collection
	*
	* @param object $hand
	* @param string $redisKey
	* @return object $hand
	*/
	protected function setHand($fullRedisKey, array $hand)
	{
		$check = $this->getHand($fullRedisKey);
		if($check) {
			$hand['round'] = $check['round'] + 1;
		} else {
			$hand['round'] = 1;
		}
		Redis::set($fullRedisKey, json_encode($hand));
		return $hand;
	}

	/**
	* get the apprpriate hand from redis
	* Return the hand as josn decoded array
	*
	* @param string $fullRedisKey
	* @return array $hand
	*/
	protected function getHand($fullRedisKey)
	{
		$hand = Redis::get($fullRedisKey);
		return json_decode($hand, true);
	}

	/**
	* Get current hand from Redi, Get new card(s) from redis deck for the game
	* Set new array with out the hand's meta data.
	* Push the new to the old array. return new hand with added card(s).
	*
	* @param string $fullRedisKey
	* @param string redisKey
	* @param integer $amount
	* @return array $hand
	*/
	protected function pushToHand($fullRedisKey, $redisKey, $amount = 1) 
	{
		$oldHand = $this->getHand($fullRedisKey);
		$hand = $oldHand['hand'];
		$card = $this->getCardsFromDeck($redisKey, $amount);
		$hand[] = $card;
		return $hand;
	}

	protected function setRound($redisKey, $round = 1)
	{
		Redis::set($redisKey.'.round', $round);
	}

	protected function getRound($redisKey)
	{
		return Redis::get($redisKey.'.round');
	}

	/**
	* Grabs random cards from the game deck. Removes the cards from the game deck
	* Saves the new game deck to redis
	*
	* @param string $redisKey
	* @param integer $amount 
	* @return object $cards
	*/
	protected function getCardsFromDeck($redisKey, $amount)
	{
		$cards = [];
		$deck = $this->getDeck($redisKey);
		$cardId = array_rand($deck, $amount);
		if(count($cardId) > 1) {
			foreach($cardId as $id) {
				$cards[] = $deck[$id];
			}
		} else {
			$cards = $deck[$cardId];
			$cardId = [0 => $cardId];
		}
		$this->removeCardsFromDeck($redisKey, $deck, $cardId);
		return $cards;
	}

	/**
	* Removes cards from deck and saves new deck to redis
	*
	* @param string $redisKey
	* @param object $deck
	* @param object $cards
	* @return boolean
	*/
	protected function removeCardsFromDeck($redisKey, $deck, $cardIds)
	{
		return $this->updateDeck($redisKey, array_diff_key($deck, $cardIds));
	}
}