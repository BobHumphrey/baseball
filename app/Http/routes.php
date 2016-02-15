<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('home');
});
Route::get('teams/standings/{year}', 'TeamsController@standings');
Route::get('nav/standings', 'NavBarFormController@standings');
Route::get('teams/franchise/{franchise}', 'TeamsController@franchise');
Route::get('teams/{team}/{year}', 'TeamsController@show');
Route::get('players/{player}', 'PlayersController@show');
Route::get('players/list/{player}', 'PlayersController@playersList');
Route::get('franchises', 'FranchisesController@index');
