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

//Route::get('booking','BookingController@index' );


//Route::get('bookingDetail/{bookingDetail}', 'BookingDetailController@show');

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
        //Route::get('accountList', 'API\AccountController@index');
        Route::put('account', 'API\AccountController@update');
        Route::delete('account', 'API\AccountController@destroy');

        //read payment info
        //Route::get('payment', 'PaymentController@index');        
        Route::get('/payment/{id}', 'PaymentController@show');
        
    });

    // buat user 
    Route::middleware(['scope:user'])->group(function () {
        //otak atik user
        Route::get('user', 'API\UserController@show');
        Route::put('user', 'API\UserController@update');

        // otak atik service
        //Route::get('service', 'ServiceController@index');

        // otak atik pickup
        //Route::get('pickup', 'PickupController@index');
        Route::get('pickup/{id}', 'PickupController@show');

        //otak atik motorcycle
        Route::get('motorcycle', 'MotorcycleController@show');
        Route::post('motorcycle', 'MotorcycleController@store');
        Route::put('motorcycle/{id}', 'MotorcycleController@update');
        Route::delete('motorcycle/{id}', 'MotorcycleController@destroy');

        //search
        Route::get('sparepart', 'SparepartController@index');
        Route::post('searchSparepart', 'SparepartController@findByName');
        Route::get('searchSparepart/{id}', 'SparepartController@findByBengkel');
        Route::get('bengkelList', 'BengkelController@index');
        Route::post('searchBengkel', 'BengkelController@findByName');

        //booking & checkprogress
        Route::post('booking','BookingController@store' );
        Route::get('checkProgress','ProgressController@index');

        //lihat payment
        //Route::get('payment', 'PaymentController@showMyPayment');

        //lihat service
        Route::get('service', 'ServiceController@show');
    });

    // buat bengkel
    Route::middleware(['scope:bengkel'])->group(function () {
        //otak atik bengkel
        //Route::post('bengkel', 'BengkelController@store');
        Route::get('bengkel', 'BengkelController@show');
        Route::put('bengkel', 'BengkelController@update');

        //otak atik payment
        Route::post('payment', 'PaymentController@store');
        Route::put('/payment/{id}', 'PaymentController@update');
        Route::delete('/payment/{id}', 'PaymentController@destroy');

        //otak atik sparepart
        Route::post('sparepart', 'SparepartController@store');
        Route::put('/sparepart/{id}', 'SparepartController@update');
        Route::delete('/sparepart/{id}', 'SparepartController@destroy');
        Route::post('searchMySparepart', 'SparepartController@findByNameInBengkel');

        //otak atik service
        Route::post('service', 'ServiceController@store');
        Route::put('/service/{id}', 'ServiceController@update');
        Route::delete('/service/{id}', 'ServiceController@destroy');

        // otak atik pickup
        Route::put('/pickup/{id}', 'PickupController@update');

        //search
        Route::get('motorcycle/{id}', 'MotorcycleController@findById');

        //booking
        Route::get('myBooking','BookingController@showMyBooking' );
        Route::put('booking/{id}','BookingController@update' );
        Route::delete('booking/{id}','BookingController@destroy');
    });

    
});


