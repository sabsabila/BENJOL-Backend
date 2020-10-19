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

//Route::get('user', 'API\UserController@index');
//Route::get('account', 'API\AccountController@index');
Route::post('login', 'API\AccountController@login');
Route::post('registerUser', 'API\AccountController@registerUser');
Route::post('registerBengkel', 'API\AccountController@registerBengkel');

/*Route::group(['middleware' => 'auth:api'], function(){
    Route::get('account/detail', 'App\Http\Controllers\Api\AccountController@details');
    Route::post('logout', 'App\Http\Controllers\Api\AccountController@logout');
    
    Route::put('account', 'App\Http\Controllers\API\AccountController@update');
    Route::delete('account', 'App\Http\Controllers\API\AccountController@destroy');

    Route::post('user', 'App\Http\Controllers\API\UserController@store');
    Route::put('user', 'App\Http\Controllers\API\UserController@update');
    Route::delete('user', 'App\Http\Controllers\API\UserController@destroy');
}); */

//buat udah login
Route::middleware(['auth:api', 'role'])->group(function() {

    // buat user & bengkel
    Route::middleware(['scope:user,bengkel'])->group(function () {
        Route::get('account', 'Api\AccountController@details');
        Route::post('logout', 'Api\AccountController@logout');
        
        Route::get('accountList', 'API\AccountController@index');
        Route::put('account', 'API\AccountController@update');
        Route::delete('account', 'API\AccountController@destroy');

    });

    // buat user 
    Route::middleware(['scope:user'])->group(function () {
        Route::get('userList', 'API\UserController@index');
        //Route::post('user', 'API\UserController@store');
        Route::get('user', 'API\UserController@show');
        Route::put('user', 'API\UserController@update');
        Route::delete('user', 'API\UserController@destroy');
    });

    // buat bengkel
    Route::middleware(['scope:bengkel'])->group(function () {
        Route::resource('bengkel', BengkelController::class);
        Route::get('bengkelList', 'BengkelController@index');
        //Route::post('bengkel', 'BengkelController@store');
        Route::get('bengkel', 'BengkelController@show');
        Route::put('bengkel', 'BengkelController@update');
        Route::delete('bengkel', 'BengkelController@destroy');

    });
    
});

/*Route::resource('bengkel', BengkelController::class);
Route::get('bengkel', 'BengkelController@index');
Route::post('bengkel', 'BengkelController@store');
Route::get('/bengkel/{id}', 'BengkelController@show');
Route::put('/bengkel/{id}', 'BengkelController@update');
Route::delete('/bengkel/{id}', 'BengkelController@destroy');*/

Route::resource('motorcycle', MotorcycleController::class);
Route::get('motorcycle', 'MotorcycleController@index');
Route::post('motorcycle', 'MotorcycleController@store');
Route::get('/motorcycle/{id}', 'MotorcycleController@show');
Route::put('/motorcycle/{id}', 'MotorcycleController@update');
Route::delete('/motorcycle/{id}', 'MotorcycleController@destroy');

Route::resource('payment', PaymentController::class);
Route::get('payment', 'PaymentController@index');
Route::post('payment', 'PaymentController@store');
Route::get('/payment/{id}', 'PaymentController@show');
Route::put('/payment/{id}', 'PaymentController@update');
Route::delete('/payment/{id}', 'PaymentController@destroy');
