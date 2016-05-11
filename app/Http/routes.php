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
Route::get('logout', 'LoginController@logout');

//首頁
Route::get('dashboard', 'LoginController@dashboard');

//報表
Route::get('go', 'MainController@go');
Route::get('boradiary/{todaydate}', 'MainController@boradiary');
Route::get('unidiary/{todaydate}' , 'MainController@unidiary');
Route::get('accountdiary/{todaydate}' , 'MainController@accountdiary');
Route::get('personaldiary/{todaydate}' , 'MainController@personaldiary');
Route::get('personalhp/{todaydate}', 'MainController@personaldiary');
Route::get('personalmedicinediary/{user}/{todaydate}' , 'MainController@personalmedicinediary');
Route::get('itemscount' , 'MainController@itemscount');
Route::get('accountreport' , 'MainController@accountreport');
Route::get('accountreportdelay' , 'MainController@accountreportdelay');
Route::post('accountreportajax' , 'ServiceajaxController@accountreportajax');
Route::get('daycheck' , 'MainController@daycheck');
Route::post('transferdailycheck' , 'ServiceajaxController@transferdailycheck');
Route::get('accountmanager' , 'MainController@accountmanager');
Route::post('accountmanagerajax' , 'ServiceajaxController@accountmanagerajax');
Route::post('accountmanagerexcel' , 'ServiceajaxController@accountmanagerexcel');
Route::get('acbudget' , 'MainController@acbudget');
Route::get('autoacbudget' , 'AutosendController@autoacbudget');
Route::get('borauni/{todaydate}' , 'MainController@borauni');
Route::get('uniuni/{todaydate}' , 'MainController@uniuni');
Route::get('agents/{todaydate}' , 'MainController@agents');
Route::get('allborauni/{todaydate}' , 'MainController@allborauni');
Route::get('imborauni/{todaydate}' , 'MainController@imborauni');
Route::get('neww' , 'MainController@neww');
//報表自動寄送
Route::get('sendboradiary', 'AutosendController@sendboradiary');
Route::get('sendunidiary' , 'AutosendController@sendunidiary');
Route::get('sendreport' , 'AutosendController@sendreport');
Route::get('accountreminder' , 'AutosendController@accountreminder');
//自動寄報表手動
Route::get('nonesendboradiary/{todaydate}', 'AutosendController@nonesendboradiary');
Route::get('nonesendunidiary/{todaydate}' , 'AutosendController@nonesendunidiary');
//匯出報表
Route::get('eisaireport', 'ExportExcelController@eisaireport');
Route::get('eisaicus', 'ExportExcelController@eisaicus');
//匯入excel
Route::get('diaryexcel', 'ExcelController@diaryexcel');
Route::get('uniexcel', 'ExcelController@uniexcel');
Route::get('haexcel', 'ExcelController@haexcel');
Route::get('boehringer', 'ExcelController@boehringer');
Route::get('boracm', 'ExcelController@boracm');
Route::get('everymonth' , 'ExcelController@everymonth');
//服務頁面
Route::get('webmail', 'MainController@webmail');
//頁面轉出excel
Route::post('transferajax' , 'ServiceajaxController@transferajax');
//TV
Route::get('tv', 'TvController@tv');

//單據
Route::get('app/it', 'ServiceController@it');
Route::get('app/epaper', 'ServiceController@epaper');
Route::get('oprocess', 'ServiceController@oprocess');
Route::post('itreceive', 'ServiceajaxController@itreceive');
Route::get('{ordernumber}/it', 'ServiceController@ordernumber');
Route::post('quickok', 'ServiceajaxController@quickok');
Route::post('itemscountajax', 'ServiceajaxController@itemscountajax');
Route::post('medicinecode', 'ServiceajaxController@medicinecode');
Route::post('company', 'ServiceajaxController@company');
Route::post('itservicerank', 'ServiceajaxController@itservicerank');
Route::get('{ordernumber}/star', 'MainController@star');
//ajax日曆呼叫
Route::post('borareportdate', 'DatechangController@borareportdate');
Route::post('unireportdate', 'DatechangController@unireportdate');
Route::post('accountreportdate', 'DatechangController@accountreportdate');

//轉址
Route::get('monitor', function()
{
    return redirect('http://192.168.1.34/nagios/');
});


//測試用
Route::get('test', 'ExcelController@test');

//管理員權限
Route::get('access', 'AdminController@access');


//沒有AD的使用者註冊
Route::get('sign', 'MainController@sign');
Route::post('signok', 'LoginController@signok');

//test
Route::get('api', 'ExcelController@api');
//Route::get('test', 'LoginController@test');




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
