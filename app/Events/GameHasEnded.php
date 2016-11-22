<?php

namespace App\Events;

class GameHasEnded
{
    public $redisKey;

    public $meta;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($redisKey, $meta)
    {
        $this->redisKey = $redisKey;
        $this->meta = $meta;
    }
}
