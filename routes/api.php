<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('black-jack/start', 'BlackJackController@start');
Route::post('black-jack/hit', 'BlackJackController@hit');
Route::post('black-jack/stay', 'BlackJackController@stay');

Route::post('texas-holdem/start', 'TexasHoldemController@start');
Route::post('texas-holdem/restart', 'TexasHoldemController@restart');
Route::post('texas-holdem/round', 'TexasHoldemController@nextRound');
Route::post('texas-holdem/fold', 'TexasHoldemController@fold');
