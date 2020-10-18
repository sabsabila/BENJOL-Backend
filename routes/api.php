<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('user', 'App\Http\Controllers\Api\UserController@index');
Route::get('account', 'App\Http\Controllers\Api\AccountController@index');
Route::post('login', 'App\Http\Controllers\API\AccountController@login');
Route::post('register', 'App\Http\Controllers\API\AccountController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('account/detail', 'App\Http\Controllers\Api\AccountController@details');
    Route::post('logout', 'App\Http\Controllers\Api\AccountController@logout');
    
    Route::put('account', 'App\Http\Controllers\API\AccountController@update');
    Route::delete('account', 'App\Http\Controllers\API\AccountController@destroy');

    Route::post('user', 'App\Http\Controllers\API\UserController@store');
    Route::put('user', 'App\Http\Controllers\API\UserController@update');
    Route::delete('user', 'App\Http\Controllers\API\UserController@destroy');
}); 
