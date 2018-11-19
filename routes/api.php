<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/completetransaction/{id}', 'TransactionController@complete');
Route::post('/declineorder/{id}', 'TransactionController@declineWithReason');
Route::post('/callmain/{id}.xml', 'XmlCallController@maincall');
Route::post('/calldeclined', 'XmlCallController@calldeclined');

Route::get('/unsupported-country-notice', 'HomeController@unsupportedcountrynotice');

Route::resource('businesses', 'Api\BusinessController', ['only' => ['show', 'index']]);

Route::get('/logreg/login', function() {
  return view('auth.login-ajax');
});

Route::get('/logreg/register', function() {
    return view('auth.register-ajax');
});

Route::get('/logreg/password/reset', function() {
  return view('auth.passwords.email-ajax');
});
