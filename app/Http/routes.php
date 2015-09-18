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
//這條沒做了但是先留著
Route::post('login', 'LoginController@login');
//登出
Route::get('logout', 'LoginController@logout');
//首頁
Route::get('dashboard', 'LoginController@dashboard');
//報表
Route::get('boradiary/{todaydate}', 'MainController@boradiary');
Route::get('unidiary/{todaydate}' , 'MainController@unidiary');
Route::get('accountdiary/{todaydate}' , 'MainController@accountdiary');
Route::get('personaldiary/{todaydate}' , 'MainController@personaldiary');
Route::get('personalmedicinediary/{user}/{todaydate}' , 'MainController@personalmedicinediary');
//test
//Route::get('/search/{category}/{term}', ['as' => 'search', 'uses' => 'LoginController@search']);
//Route::get('pp', 'LoginController@pp');
//匯入excel
Route::get('diaryexcel', 'ExcelController@diaryexcel');
Route::get('uniexcel', 'ExcelController@uniexcel');
Route::get('haexcel', 'ExcelController@haexcel');

//TV
Route::get('tv', 'TvController@tv');

//單據
Route::get('it', 'ServiceController@it');
Route::post('itreceive', 'ServiceajaxController@itreceive');
//ajax日曆呼叫
Route::post('borareportdate', 'DatechangController@borareportdate');
Route::post('unireportdate', 'DatechangController@unireportdate');
Route::post('accountreportdate', 'DatechangController@accountreportdate');

//管理員權限
Route::get('access', 'AdminController@access');

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
