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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('login', 'MainController@login');
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout');
Route::get('/first', 'MainController@first');
Route::get('/second', 'MainController@second');
Route::get('/third', 'MainController@third');
Route::get('/fourth', 'MainController@fourth');
Route::get('/fifth', 'MainController@fifth');
Route::post('/reportdate', 'datechangController@reportdate');
Route::get('sign', 'MainController@sign');
Route::post('sign', 'MainController@signc');


Route::get('/test', function()
{
    // pages 為網站進入點
    return View('home');
});
/*看sql用
Event::listen('illuminate.query', function($query)
{
    var_dump($query);
});
*/ 
