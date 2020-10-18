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

Route::resource('payment', PaymentController::class);
Route::get('payment', 'PaymentController@index');
Route::post('payment', 'PaymentController@store');
Route::get('/payment/{id}', 'PaymentController@show');
Route::put('/payment/{id}', 'PaymentController@update');
Route::delete('/payment/{id}', 'PaymentController@destroy');

Route::resource('sparepart', SparepartController::class);
Route::get('sparepart', 'SparepartController@index');
Route::post('sparepart', 'SparepartController@store');
Route::get('/sparepart/{id}', 'SparepartController@show');
Route::put('/sparepart/{id}', 'SparepartController@update');