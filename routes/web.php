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

Auth::routes();
