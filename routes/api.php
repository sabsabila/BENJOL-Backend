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
Route::resource('booking', BookingController::class);
//Route::get('bookingDetail', BookingController::class);
Route::get('bookingDetail/{bookingDetail}', 'BookingDetailController@show');

Route::post('login', 'API\AccountController@login');
Route::post('registerUser', 'API\AccountController@registerUser');
Route::post('registerBengkel', 'API\AccountController@registerBengkel');

//buat udah login
Route::middleware(['auth:api', 'role'])->group(function() {

    // buat user & bengkel
    Route::middleware(['scope:user,bengkel'])->group(function () {
        //account detail & logout
        Route::get('account', 'Api\AccountController@details');
        Route::post('logout', 'Api\AccountController@logout');
        
        //account list, edit & delete account
        Route::get('accountList', 'API\AccountController@index');
        Route::put('account', 'API\AccountController@update');
        Route::delete('account', 'API\AccountController@destroy');

        //read payment info
        Route::resource('payment', PaymentController::class);
        Route::get('payment', 'PaymentController@index');        
        Route::get('/payment/{id}', 'PaymentController@show');

        //list sparepart
        Route::resource('sparepart', SparepartController::class);
        Route::get('sparepart', 'SparepartController@index');
        Route::get('/sparepart/{id}', 'SparepartController@show');
    });

    // buat user 
    Route::middleware(['scope:user'])->group(function () {
        //otak atik user
        Route::get('userList', 'API\UserController@index');
        //Route::post('user', 'API\UserController@store');
        Route::get('user', 'API\UserController@show');
        Route::put('user', 'API\UserController@update');
        Route::delete('user', 'API\UserController@destroy');

        // otak atik service
        Route::get('service', 'ServiceController@index');

        // otak atik pickup
        Route::get('pickup', 'PickupController@index');

        //otak atik motorcycle
        Route::resource('motorcycle', MotorcycleController::class);
        Route::get('motorcycleList', 'MotorcycleController@index');
        Route::post('motorcycle', 'MotorcycleController@store');
        Route::get('motorcycle', 'MotorcycleController@show');
        Route::put('motorcycle/{id}', 'MotorcycleController@update');
        Route::delete('motorcycle/{id}', 'MotorcycleController@destroy');
    });

    // buat bengkel
    Route::middleware(['scope:bengkel'])->group(function () {
        //otak atik bengkel
        Route::resource('bengkel', BengkelController::class);
        Route::get('bengkelList', 'BengkelController@index');
        //Route::post('bengkel', 'BengkelController@store');
        Route::get('bengkel', 'BengkelController@show');
        Route::put('bengkel', 'BengkelController@update');
        Route::delete('bengkel', 'BengkelController@destroy');

        //otak atik payment
        Route::post('payment', 'PaymentController@store');
        Route::put('/payment/{id}', 'PaymentController@update');
        Route::delete('/payment/{id}', 'PaymentController@destroy');

        //otak atik sparepart
        Route::post('sparepart', 'SparepartController@store');
        Route::put('/sparepart/{id}', 'SparepartController@update');
        Route::delete('/sparepart/{id}', 'SparepartController@destroy');

        //otak atik service
        Route::post('service', 'ServiceController@store');
        Route::put('/service/{id}', 'ServiceController@update');
        Route::delete('/service/{id}', 'ServiceController@delete');

        // otak atik pickup
        Route::post('pickup', 'PickupController@store');
        Route::put('/pickup/{id}', 'PickupController@update');
        Route::delete('/pickup/{id}', 'PickupController@delete');
    });

    
});
