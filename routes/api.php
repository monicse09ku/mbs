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

Route::post('/login', 'Api\LoginController@login');
Route::post('/register', 'Api\LoginController@register');
Route::apiResource('accounts', 'Api\AccountController');
Route::apiResource('transactions', 'Api\TransactionController');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    // List articles
	//Route::apiResource('accounts', 'Api\AccountController');
	//Route::apiResource('transactions', 'Api\TransactionController');
});
