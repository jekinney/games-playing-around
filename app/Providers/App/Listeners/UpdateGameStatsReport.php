<?php

namespace App\Providers\App\Listeners;

use App\Providers\App\Events\GameHasEnded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateGameStatsReport
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  GameHasEnded  $event
     * @return void
     */
    public function handle(GameHasEnded $event)
    {
        //
    }
}
