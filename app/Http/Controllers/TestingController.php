<?php

namespace App\Http\Controllers;

use App\Games\Models\BlackJack;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function index(BlackJack $blackJack)
    {
    	//return $blackJack->start(5);
    	return $blackJack->stay('blackjack.SgPIiTkbOm');
    }
}
