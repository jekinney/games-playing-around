<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Games\Models\BlackJackGame;

class BlackJackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('games.black-jack');
    }

    public function start(Request $request, BlackJackGame $blackJack)
    {
        return response()->json($blackJack->startGame($request->bet, $request->chips));
    }

    public function hit(Request $request, BlackJackGame $blackJack)
    {
        return response()->json($blackJack->hit($request->key));
    }

    public function stay(Request $request, BlackJackGame $blackJack)
    {
        dd($request->all());
    }
}
