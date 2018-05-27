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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/game/{id}', 'GamesController@games');
Route::get('/user', 'GamesController@user');
Route::get('/home', 'HomeController@index')->name('home');


Route::get('/play/{game_id}', 'PlayGame@game');
Route::get('/ready/{session}', 'PlayGame@wait');
Route::post('/winner/{session_id}/password/{winner_code}', 'PLayGame@winner');
