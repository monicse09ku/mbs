<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth.basic');
/*
Route::get('accounts', 'Api\AccountController@index')->middleware('auth.basic');
Route::get('transactions', 'Api\TransactionController@index')->middleware('auth.basic');*/

/*Route::apiResource('accounts', 'Api\AccountController')->middleware('auth.basic');
Route::apiResource('transactions', 'Api\TransactionController')->middleware('auth.basic');
*/

Route::apiResources([
            'accounts' => 'AccountController',
            'transactions' => 'TransactionController',
        ]);