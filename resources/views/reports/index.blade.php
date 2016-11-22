@extends('layouts.app')

@section('content')
<div class="container">
    <header class="page-header text-center">
        <h1>Game Reports</h1>
    </header>

    <main class="row">
        <aside class="col-xs-3 col-md-2">
            <section class="panel panel-default">
                <header class="panel-heading text-center">
                    <h2 class="panel-title">Reports By Game</h2>
                </header>
                <section class="list-group text-center">
                    <a href="/reports/game/blackjack" class="list-group-item">Black Jack</a>
                    <a href="reports/game/mppoker" class="list-group-item">Multiplayer Poker</a>
                    <a href="reports/game/texasholdem" class="list-group-item">Texas Hold'em</a>
                    <a href="reports/game/videopoker" class="list-group-item">Video Poker</a>
                </section>
            </section>
        </aside>
        
        <section class="col-xs-9 col-md-10">
            <table class="table">
                <thead>
                    <tr>
                        <th>Redis Key</th>
                        <th>Game</th>
                        <th>Status Code</th>
                        <th>Winner</th>
                        <th>Bets</th>
                        <th>Pay out</th>
                        <th>Ended at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td><a href="/reports/game/details/{{ $report['key'] }}">
                                {{ $report['key'] }}
                            </a></td>
                            <td>{{ strtoupper($report['game']) }}</td>
                            <td>{{ $report['status_code'] }}</td>
                            <td>{{ $report['winner'] }}</td>
                            <td>{{ $report['bet'] }}</td>
                            <td>{{ $report['payout'] }}</td>
                            <td>{{ Carbon\Carbon::parse($report['end_at'])->diffForHumans() }}</td>
                        </td>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>

</div>
@endsection
