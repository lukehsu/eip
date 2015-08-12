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
//登入
Route::get('login', 'MainController@login');
Route::post('login', 'LoginController@login');
//登出
Route::post('logout', 'LoginController@logout');
//報表
Route::get('diary', 'MainController@diary');
Route::get('month', 'MainController@month');
//匯入excel
Route::get('diaryexcel', 'MainController@diaryexcel');




Route::get('/first', 'MainController@first');
Route::get('/third', 'MainController@third');
Route::post('/reportdate', 'datechangController@reportdate');
Route::get('sign', 'MainController@sign');
Route::post('sign', 'MainController@signc');
Route::get('gg', 'MainController@gg');




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
