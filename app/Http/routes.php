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
Route::get('loginau', 'AutosendController@loginau');

//登出
Route::get('logout', 'LoginController@logout');

//首頁
Route::get('dashboard', 'LoginController@dashboard');

//報表
//各組業績查詢用
Route::get('gpgo', 'MainController@gpgo');
Route::get('acdetail', 'MainController@acdetail');
Route::get('sendgo', 'AutosendController@sendgo');
Route::get('hpgo', 'MainController@hpgo');
Route::get('unigo', 'MainController@gpgo');
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
Route::get('logincount' , 'AutosendController@logincount');
Route::get('heathycheck' , 'MainController@heathycheck');
Route::post('heathycheckajax' , 'FajaxController@heathycheckajax');
//報表自動寄送
Route::get('sendboradiary', 'AutosendController@sendboradiary');
Route::get('sendunidiary' , 'AutosendController@sendunidiary');
Route::get('sendreport' , 'AutosendController@sendreport');
Route::get('accountreminder' , 'AutosendController@accountreminder');
Route::get('sendlogincount' , 'AutosendController@sendlogincount');
Route::get('sendmeal' , 'AutosendController@sendmeal');
//自動寄報表手動
Route::get('nonesendboradiary/{todaydate}', 'AutosendController@nonesendboradiary');
Route::get('nonesendunidiary/{todaydate}' , 'AutosendController@nonesendunidiary');
Route::get('sendha' , 'AutosendController@sendha');
Route::get('createha' , 'AutosendController@createha');
Route::get('sendinfosafe' , 'AutosendController@sendinfosafe');
//匯出報表
Route::get('eisaireport', 'ExportExcelController@eisaireport');
Route::get('eisaicus', 'ExportExcelController@eisaicus');
//匯入excel
Route::get('diaryexcel', 'ExcelController@diaryexcel');
Route::get('uniexcel', 'ExcelController@uniexcel');
Route::get('haexcel', 'ExcelController@haexcel');
Route::get('healcome', 'ExcelController@healcome');
Route::get('boehringer', 'ExcelController@boehringer');
Route::get('boracm', 'ExcelController@boracm');
Route::get('everymonth' , 'ExcelController@everymonth');
//服務頁面
Route::get('webmail', 'MainController@webmail');
Route::get('stationery', 'MainController@stationery');
//頁面轉出excel
Route::post('transferajax' , 'ServiceajaxController@transferajax');
//TV
Route::get('tv', 'TvController@tv');
//行政總務
Route::get('createvendor', 'MainController@createvendor');
Route::get('orderlu', 'MainController@orderlu');
Route::get('vendorfun', 'MainController@vendorfun');
Route::get('orderfun', 'MainController@orderfun');
Route::get('orderdetail', 'MainController@orderdetail');
Route::get('stationerycheck', 'MainController@stationerycheck');
Route::post('orderluajax', 'FajaxController@orderluajax');
Route::post('vendorfunajax', 'FajaxController@vendorfunajax');
Route::post('vendorfundelajax', 'FajaxController@vendorfundelajax');
Route::post('orderfunajax', 'FajaxController@orderfunajax');
Route::post('stationeryajax', 'FajaxController@stationeryajax');
Route::post('stationerycheckajax', 'FajaxController@stationerycheckajax');
//資訊部
Route::get('systemcheck', 'MainController@systemcheck');
Route::get('systemcreate', 'MainController@systemcreate');
Route::post('systemcreateajax', 'FajaxController@systemcreateajax');
Route::post('systemupdateajax', 'FajaxController@systemupdateajax');
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
Route::post('chooseman', 'FajaxController@chooseman');
Route::post('createvendorajax', 'FajaxController@createvendorajax');
Route::post('chooseproduct', 'FajaxController@chooseproduct');
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
