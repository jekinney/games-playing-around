<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Games\Models\BlackJack;

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

    public function start(Request $request, BlackJack $blackJack)
    {
        return response()->json($blackJack->start($request->bet));
    }

    public function hit(Request $request, BlackJack $blackJack)
    {
        return response()->json($blackJack->hit($request->key));
    }

    public function stay(Request $request, BlackJack $blackJack)
    {
       return response()->json($blackJack->stay($request->key));
    }
}
