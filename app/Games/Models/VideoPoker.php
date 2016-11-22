<?php

namespace App\Games\Models;

use App\Games\Decks\Basic;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

class VideoPoker extends Basic
{
    public function start($bet, $chips = 1000)
    {

    }

    public function replaceDiscard($request)
    {

    }

    protected function setPlayerHandMeta()
    {
    	
    }
}
