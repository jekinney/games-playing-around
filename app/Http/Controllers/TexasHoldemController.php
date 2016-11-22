<?php

namespace App\Http\Controllers;

use App\Games\Models\TexasHoldem;
use Illuminate\Http\Request;

class TexasHoldemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('games.texas-holdem');
    }

    public function start(Request $request, TexasHoldem $texas)
    {
        return response()->json($texas->deal($request->bet));
    }

    public function restart(Request $request, TexasHoldem $texas)
    {
        return response()->json($texas->deal($request->bet, $request->key));
    }

    public function nextRound(Request $request, TexasHoldem $texas)
    {
        return response()->json($texas->round($request->bet, $request->key));
    }

}
