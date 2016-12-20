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

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/redis', function(){
	return 'redis';
});

//LINE API
Route::get('/v1/service/rental/{ids}', 'ApiController@index');
Route::get('/v1/service/rental/a/{ids}', 'ApiController@create');
//Route::get('/v1/get/{ids}', 'ApiController@index');

//test root
Route::get('/test', function(){
	return view('detail');
});

//Messaging APIルート
Route::post('/v1/bot/callback', 'MessagingApiController@index');

//ファイルダウンロード
Route::get('/stu/exp/3', 'StudentExperimentController@index');
Route::get('/stu/sol', 'StudentExperimentController@solve');
Route::get('/stu/exp/download', 'StudentExperimentController@download()');

Route::controller('linebot/callback', 'LinebotController');

Route::controller('v2/callback', 'ApiLineBotController');

//amazon dash button
Route::get('v1/push/amazon/dash/{mes}', 'AmazonDashButtonController@index');
Route::controller('v1/reply/amazon/dash', 'AmazonDashButtonController');
//Route::controller('v1/api/response', 'ApiResponseController');

Route::controller('v1/MP/callback', 'MPCallbackController');
