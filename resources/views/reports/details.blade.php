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
                    <a href="/reports/all" class="list-group-item">Reports</a>
                    <a href="/reports/game/blackjack" class="list-group-item">Black Jack</a>
                    <a href="reports/game/mppoker" class="list-group-item">Multiplayer Poker</a>
                    <a href="reports/game/texasholdem" class="list-group-item">Texas Hold'em</a>
                    <a href="reports/game/videopoker" class="list-group-item">Video Poker</a>
                </section>
            </section>
        </aside>
        
        <section class="col-xs-9 col-md-10">

            <div class="row">

                <div class="col-md-6">
                    <section class="panel panel-primary">
                        <heading class="panel-heading">
                            <h2 class="panel-title">Dealer</h2>
                        </heading>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Suit</th>
                                    <th>Value</th>
                                    <th>Alt Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dealer->hand as $card)
                                    <tr>
                                        <td>{{ $card->suit }}</td>
                                        <td>{{ $card->value }}</td>
                                        <td>{{ $card->alt_value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                </div>

                <div class="col-md-6">
                    <section class="panel panel-primary">
                        <heading class="panel-heading">
                            <h2 class="panel-title">Player</h2>
                        </heading>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Card</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($players->hand as $card)
                                    <tr>
                                        <td>{{ $card->suit }}</td>
                                        <td>{{ $card->value }}</td>
                                        <td>{{ $card->alt_value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </section>
    </main>

</div>
@endsection
