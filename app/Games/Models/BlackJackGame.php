<?php

namespace App\Games\Models;

use App\Games\Decks\BlackJack;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

class BlackJackGame extends BlackJack
{
	// Start game. triggers set up and caching.
	public function startGame($bet, $chips = 1000)
	{
		//inital deck array	
		$key = $this->setCache(['deck' => $this->deck]);

		// Set player hand array with 2 random cards and meta data.
		$player = $this->setPlayerHand($key, 2);

		// Set dealer hand array with 2 random cards and meta data.
		$dealer = $this->setDealerHand($key, 2);

		$this->updateCache($key, [
			'bet' => $bet, 
			'chips' => $chips, 
			'deck' => $deck, 
			'player' => $player, 
			'dealer' => $dealer,
		]);

		return collect(['key' => $key, 'bet' => $bet, 'chips' => $chips, 'player' => $player, 'dealer' => $dealer]);
	}

	// When a player requests a card or hit
	public function hit($key)
	{
		$hand = $this->setPlayerHand($key);
		$this->updateCache($key, [
			'player' => $hand
		]);

		return collect(['key' => $key, 'player' => $hand]);
	}

	// randomly select card or cards from the cached deck, then remove the selected card from the deck.
	protected function getCardsFromDeck($key, $amount = 1)
	{
		$deck = $this->getCache($key)['deck'];
		$cards = array_only($deck, array_rand($deck, $amount));
		$this->updateCache($key, array_diff_key($deck, $cards));

		return $cards;
	}

	// Set the players hand array for sending to the game page
	protected function setPlayerHand($key, $amount = 1) 
	{
		$hand = $this->getCardsFromDeck($key, $amount);
		$hand = $this->mergeHandFromCache($key, $hand, 'player');

		return $this->setPlayerHandMeta($hand);
	}

	// Set the dealers hand array for sending tot he game page
	protected function setDealerHand($key, $amount = 1)
	{
		$hand = $this->getCardsFromDeck($key, $amount);
		$hand = $this->mergeHandFromCache($key, $hand, 'dealer');

		return $this->setDealerHandMeta($hand);
	}

	// Set the required meta data to the players hand array such as total of cards worth, win or over messages etc.
	protected function setPlayerHandMeta($hand)
	{
		$hand = $this->setBasicHandMeta($hand);

		return $hand;
	}

	// Set the required meta data to the dealers hand array such as total of cards worth, win or over messages etc.
	protected function setDealerHandMeta($hand)
	{
		$hand = $this->setBasicHandMeta($hand);

		return $hand;
	}

	// Basic meta data required for both a player's and dealer's hands
	protected function setBasicHandMeta($hand)
	{
		$meta = ['face_value' => 0, 'ace_value' => 0, 'status' => null];

		foreach($hand as $card) {
			$meta['face_value'] = $meta['face_value'] + $card['value'];
			if($card['value'] == 1) {
				$meta['ace_value'] = $meta['ace_value'] + 1;
			}
		}

		if($meta['ace_value'] > 0) {
			$meta['ace_value'] = ($meta['ace_value'] * 11) + ($meta['face_value'] - $meta['ace_value']);
		}

		return array_add($hand, 'meta', $meta);
	}

	// Generate a random cache key and start caching
	protected function setCache(array $data)
	{
		$key = str_random(10);		
		Cache::put($key, $data, 20);

		return $key;
	}

	// Update the current cache, also reset the deck array keys to elimanate future card requests getting a key that doesn't exsist
	protected function updateCache($key, array $data)
	{
		if(isset($data['deck'])) {
			array_values($data['deck']);
		}
		Cache::put($key, $data);
	}

	// Get cahced data by key from the cache
	protected function getCache($key) 
	{
		if(Cache::has($key)) {
			return Cache::get($key);
		}
		return false;
	}

	// Adding a new card or cards to the cached applicable hand array from the cache
	protected function mergeHandFromCache($key, $hand, $handType)
	{
		$cache = $this->getCache($key);
		if($cache && isset($cache[$handType]))
		{
			dd($cache);
			$hand = collect($cache[$handType])->merge($hand)->flatten()->toArray();
		}
		
		return $hand;
	}
}