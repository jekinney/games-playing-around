@extends('layouts.app')

@section('content')
<div class="container">
    <header class="page-header text-center">
        <h1>Select a game!</h1>
    </header>

    <div class="row">
        <section class="col-sm-6 col-lg-3">
            <div class="panel panel-default">
                <article class="panel-body text-center">
                    <a href="/black-jack" class="btn btn-primary">Black Jack</a>
                </article>
            </div>
        </section>
        
        <section class="col-sm-6 col-lg-3">
            <div class="panel panel-default">
                <article class="panel-body text-center">
                    <a href="/mp-poker" class="btn btn-primary">Multiplayer Poker</a>
                </article>
            </div>
        </section>

        <section class="col-sm-6 col-lg-3">
            <div class="panel panel-default">
                <article class="panel-body text-center">
                    <a href="texas-holdem" class="btn btn-primary">Texas Hold'em</a>
                </article>
            </div>
        </section>

        <section class="col-sm-6 col-lg-3">
            <div class="panel panel-default">
                <article class="panel-body text-center">
                    <a href="video-poker" class="btn btn-primary">Video Poker</a>
                </article>
            </div>
        </section>
    </div> 
</div>
@endsection
