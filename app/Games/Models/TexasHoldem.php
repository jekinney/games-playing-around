<?php

namespace App\Games\Models;

use App\Games\Deck\Decks;
use App\Games\Traits\RedisDatastore;

class TexasHoldem
{
    use RedisDatastore;

    public function deal($bet, $redisKey = null)
    {
        $redisKey = $this->setDeck('texasholdem', $redisKey);
        $playersHand = $this->setPlayersHand($redisKey);
        $this->setRound($redisKey);

        return collect(['game' => $redisKey, 'player' => $playersHand]);
    }

    public function round($bet, $redisKey)
    {
        $round = $this->getRound($redisKey);
        $amount = 1;
        if($round == 1) {
            $amount = 3;
        }
        $hand = $this->setDealersHand($redisKey, $amount);
        return collect(['dealer' => $hand]);
    }

    protected function setPlayersHand($redisKey)
    {
        $hand = $this->getCardsFromDeck($redisKey, 2);
        return $this->setHand($redisKey.'.player', $hand);
    }

    protected function setDealersHand($redisKey, $amount)
    {
        $oldHand = $this->getHand($redisKey.'.dealer');
        if(count($oldHand) == 5) {
            return $oldHand;
        } 
        $hand = $this->getCardsFromDeck($redisKey, $amount);
        if(count($oldHand) > 0) {
            $hand = $oldHand->prepend($hand->toArray());
        }
        return $this->setHand($redisKey.'.dealer', $hand);
    }

    protected function basicMeta($hand, $dealer = false)
    {
    	
    }
}
