<?php

namespace App\Listeners;


use App\Events\GameHasEnded;
use App\Reports\Models\Report;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateGameStatsReport
{
    protected $report;

    function __construct(Report $report)
    {
        $this->report = $report;
    }
    /**
     * Handle the event.
     *
     * @param  GameHasEnded  $event
     * @return void
     */
    public function handle(GameHasEnded $event)
    {
        $current = [
            'key' => $event->redisKey, 
            'game' => explode('.', $event->redisKey)[0],
            'status_code' => $event->meta['status'], 
            'winner' => $event->meta['dealer']? 'house':'player',
            'bet' => null,
            'payout' => null,
            'end_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ];
        $this->report->add($current);
    }
}
