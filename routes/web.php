<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Route::get('black-jack', 'BlackJackController@index');
Route::get('mp-poker', 'PokerController@index');
Route::get('texas-holdem', 'TexasHoldemController@index');
Route::get('video-poker', 'VideoPokerController@index');

Route::get('reports/all', 'GameReportsController@index');
Route::get('reports/game/{gamename}', 'GameReportsController@show');
Route::get('reports/game/details/{redisKey}', 'GameReportsController@details');
Route::get('testing', 'TestingController@index');
Auth::routes();
