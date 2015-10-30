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

//報表自動寄送
Route::get('sendboradiary', 'AutosendController@sendboradiary');
Route::get('sendunidiary' , 'AutosendController@sendunidiary');
Route::get('sendreport' , 'AutosendController@sendreport');
//自動寄報表手動
Route::get('nonesendboradiary/{todaydate}', 'AutosendController@nonesendboradiary');
Route::get('nonesendunidiary/{todaydate}' , 'AutosendController@nonesendunidiary');

//匯入excel
Route::get('diaryexcel', 'ExcelController@diaryexcel');
Route::get('uniexcel', 'ExcelController@uniexcel');
Route::get('haexcel', 'ExcelController@haexcel');
Route::get('boehringer', 'ExcelController@boehringer');
//TV
Route::get('tv', 'TvController@tv');

//單據
Route::get('app/it', 'ServiceController@it');
Route::post('itreceive', 'ServiceajaxController@itreceive');
Route::get('{ordernumber}/it', 'ServiceController@ordernumber');
Route::post('quickok', 'ServiceajaxController@quickok');
//ajax日曆呼叫
Route::post('borareportdate', 'DatechangController@borareportdate');
Route::post('unireportdate', 'DatechangController@unireportdate');
Route::post('accountreportdate', 'DatechangController@accountreportdate');

//轉址
Route::get('monitor', function()
{
    return redirect('http://192.168.1.34/nagios/');
});

//管理員權限
Route::get('access', 'AdminController@access');


//test
Route::get('api', 'ExcelController@api');

/*
測試中間層
Route::get('/test', function()
{
    // pages 為網站進入點
    return View('home');
});
看sql用
Event::listen('illuminate.query', function($query)
{
    var_dump($query);
});
*/ 
