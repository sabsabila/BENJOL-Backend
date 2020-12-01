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

Route::get('bengkelList', 'BengkelController@index');
Route::post('searchBengkel', 'BengkelController@findByName');

Route::get('sparepart', 'SparepartController@index');
Route::post('searchSparepart', 'SparepartController@findByName');

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
        
        //edit & delete account
        Route::put('account', 'API\AccountController@update');
        Route::delete('account', 'API\AccountController@destroy');
        
        Route::get('motorcycle/{id}', 'MotorcycleController@findById');
        
    });

    // buat user 
    Route::middleware(['scope:user'])->group(function () {
        //otak atik user
        Route::get('user', 'API\UserController@show');
        Route::put('user', 'API\UserController@update');

        // otak atik pickup
        Route::get('pickup', 'PickupController@show');

        //otak atik payment
        Route::put('uploadReceipt', 'PaymentController@updateReceipt');
        Route::get('payment', 'PaymentController@showMyPayment');

        //otak atik motorcycle
        Route::get('motorcycle', 'MotorcycleController@show');
        Route::post('motorcycle', 'MotorcycleController@store');
        Route::put('motorcycle/{id}', 'MotorcycleController@update');
        Route::delete('motorcycle/{id}', 'MotorcycleController@destroy');

        //search
        Route::get('sparepartBengkel/{id}', 'SparepartController@findByBengkel');
        Route::post('searchSparepartBengkel/{id}', 'SparepartController@searchInBengkel');
        Route::get('bengkel/{id}', 'BengkelController@getBengkel');

        //booking & checkprogress
        Route::post('booking','BookingController@store' );
        Route::get('booking','BookingController@userBooking');
        Route::get('checkProgress','ProgressController@index');

        //lihat service
        Route::get('service/{id}', 'ServiceController@show');

        //see booking detail
        Route::get('bookingDetail','BookingDetailController@show');
    });

    // buat bengkel
    Route::middleware(['scope:bengkel'])->group(function () {
        //otak atik bengkel
        Route::get('bengkel', 'BengkelController@show');
        Route::put('bengkel', 'BengkelController@update');

        //otak atik payment
        Route::put('/finishPayment/{id}', 'PaymentController@updateStatus');
        Route::get('bengkelPayment', 'PaymentController@showBengkelPayment');

        //otak atik sparepart
        Route::get('mySpareparts', 'SparepartController@mySparepartList');
        Route::get('sparepart/{id}', 'SparepartController@show');
        Route::post('sparepart', 'SparepartController@store');
        Route::put('/sparepart/{id}', 'SparepartController@update');
        Route::delete('/sparepart/{id}', 'SparepartController@destroy');
        Route::post('searchMySparepart', 'SparepartController@findByNameInBengkel');

        //otak atik service
        Route::post('service', 'ServiceController@store');
        Route::put('/service/{id}', 'ServiceController@update');
        Route::delete('/service/{id}', 'ServiceController@destroy');
        Route::get('service', 'ServiceController@myServices');

        // otak atik pickup
        Route::put('/pickup/{id}', 'PickupController@update');

        //booking
        Route::get('myBooking','BookingController@showMyBooking' );
        Route::put('booking/{id}','BookingController@update' );
        Route::delete('booking/{id}','BookingController@destroy');
        Route::put('bookingDetail/{id}','BookingDetailController@update');
        Route::get('myBookingDetail','BookingController@showInBengkel');

        //user
        Route::get('userInfo/{id}','API\UserController@seeUser' );
    });

    
});


