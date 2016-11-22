<?php

namespace App\Reports\Models;

use Illuminate\Support\Facades\Redis;

class Report
{
    public function all()
    {
    	$reports = Redis::get('game.reports');
    	return array_reverse(json_decode($reports, true));
    }

    public function add(array $current)
    {
    	$reports = $this->all();
    	$reports[] = $current;
    	Redis::set('game.reports', json_encode($reports));
    }

    public function game($gameName)
    {
    	return collect(array_reverse($this->all()))->filter(function($value, $key) use($gameName) {
    		if($value['game'] == $gameName) {
    			return $value;
    		}
    	});
    }

    public function gameDetails($redisKey)
    {
    	$player = Redis::get($redisKey.'.player');
    	$dealer = Redis::get($redisKey.'.dealer');

    	return collect(['player' => json_decode($player), 'dealer' => json_decode($dealer)]);
    }
}
