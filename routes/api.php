<?php

use App\Http\Controllers\PickupController;
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

Route::resource('service',ServiceController::class);
Route::resource('pickup',PickupController::class);
Route::get('service/bookingDetail/{id}',[ServiceController::class,'getBookingDetail']);
Route::get('pickup/booking/{id}',[PickupController::class,'getBooking']);