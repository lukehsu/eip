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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('test', 'TestController@index');

Route::get('home1', 'HomeController@jj');

//Route::group(['prefix'=>'post'],function(){

/*Route::get('create', 'TestController@create');

Route::get('edit/{id}', 'TestController@edit');

Route::post('/', 'TestController@store');

Route::put('{id}', 'TestController@update');

Route::delete('{id}', 'TestController@destroy');

Route::get('{id}', 'TestController@show');*/
//Route::resource('post', 'testController');

Route::resource('post', 'testController', ['only' => ['create','store','destroy']]);

//});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
