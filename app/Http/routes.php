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
//首頁
Route::get('dashboard', 'LoginController@dashboard');
//報表
Route::get('boradiary/{todaydate}', 'MainController@boradiary');
Route::get('unidiary' , 'MainController@unidiary');
Route::get('accountdiary' , 'MainController@accountdiary');
Route::get('personaldiary' , 'LoginController@personaldiary');

Route::get('/search/{category}/{term}', ['as' => 'search', 'uses' => 'LoginController@search']);
Route::get('pp', 'LoginController@pp');
//匯入excel
Route::get('diaryexcel', 'ExcelController@diaryexcel');
Route::get('uniexcel', 'ExcelController@uniexcel');


//ajax日曆呼叫
Route::post('borareportdate', 'DatechangController@borareportdate');
Route::post('unireportdate', 'DatechangController@unireportdate');
Route::post('accountreportdate', 'DatechangController@accountreportdate');




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
