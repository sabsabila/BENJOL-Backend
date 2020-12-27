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

Route::get('bengkel/all', 'BengkelController@index');
Route::post('bengkel/search', 'BengkelController@findByName');

Route::get('sparepart', 'SparepartController@index');
Route::post('sparepart/search', 'SparepartController@findByName');

Route::post('login', 'Api\UserController@login');
Route::post('user/register', 'Api\UserController@registerUser');
Route::post('bengkel/register', 'Api\UserController@registerBengkel');

//buat udah login
Route::middleware(['auth:api', 'role'])->group(function() {

    // buat user & bengkel
    Route::middleware(['scope:user,bengkel'])->group(function () {
        //logout
        Route::post('logout', 'Api\UserController@logout');
        
    });

    // buat user 
    Route::middleware(['scope:user'])->group(function () {
        //otak atik user
        Route::get('user', 'Api\ClientController@show');
        Route::put('user', 'Api\ClientController@update');
        Route::put('user/password', 'Api\ClientController@changePassword');
        Route::post('user/image', 'Api\ClientController@upload');

        // otak atik pickup
        Route::get('pickup/{id}', 'PickupController@show');
        Route::get('pickup', 'PickupController@showAll');

        //otak atik payment
        Route::post('upload/receipt/{id}', 'PaymentController@updateReceipt');
        Route::get('payment/{id}', 'PaymentController@showMyPayment');

        //otak atik motorcycle
        Route::get('motorcycle', 'MotorcycleController@show');
        Route::post('motorcycle', 'MotorcycleController@store');
        Route::put('motorcycle/{id}', 'MotorcycleController@update');
        Route::delete('motorcycle/{id}', 'MotorcycleController@destroy');
        Route::get('motorcycle/{id}', 'MotorcycleController@findById');

        //search
        Route::get('sparepart/bengkel/{id}', 'SparepartController@findByBengkel');
        Route::post('sparepart/bengkel/search/{id}', 'SparepartController@searchPerBengkel');
        Route::get('bengkel/{id}', 'BengkelController@getBengkel');

        //booking & checkprogress
        Route::post('booking','BookingController@store' );
        Route::get('booking','BookingController@userBooking');
        Route::get('booking/all','BookingController@userBookingAll');
        Route::get('progress/{id}','ProgressController@index');

        //lihat service
        Route::get('service/{id}', 'ServiceController@show');
    });

    // buat bengkel
    Route::middleware(['scope:bengkel'])->group(function () {
        //otak atik bengkel
        Route::get('bengkel', 'BengkelController@show');
        Route::put('bengkel', 'BengkelController@update');

        //otak atik payment
        Route::put('payment/status/{id}', 'PaymentController@updateStatus');
        Route::get('bengkelPayment', 'PaymentController@showBengkelPayment');

        //otak atik sparepart
        Route::get('bengkelSparepart', 'SparepartController@bengkelSparepartList');
        Route::get('sparepart/{id}', 'SparepartController@show');
        Route::post('sparepart', 'SparepartController@store');
        Route::put('/sparepart/{id}', 'SparepartController@update');
        Route::delete('/sparepart/{id}', 'SparepartController@destroy');
        Route::post('bengkelSparepart/search', 'SparepartController@SearchInBengkel');

        //otak atik service
        Route::post('service', 'ServiceController@store');
        Route::put('/service/{id}', 'ServiceController@update');
        Route::delete('/service/{id}', 'ServiceControiller@destroy');
        Route::get('service', 'ServiceController@myServices');

        // otak atik pickup
        Route::put('pickup/{id}', 'PickupController@update');
        Route::get('bengkelPickup','PickupController@showBengkelPickups' );

        //booking
        Route::get('bengkelBooking','BookingController@showBengkelBooking' );
        Route::put('booking/{id}','BookingController@update' );
        Route::put('bookingStatus/{id}','BookingController@setBookingStatus' );
        Route::delete('booking/{id}','BookingController@destroy');
        Route::put('bookingDetail/{id}','BookingDetailController@update');
        Route::post('booking/count', 'BookingController@bookingCount');
        Route::post('revenue/count', 'BookingDetailController@revenueCount');

        //user
        Route::get('user/info/{id}','Api\ClientController@seeUser' );
    });

    
});


