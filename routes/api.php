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

// Route::resource('service','App\Http\Controllers\ServiceController',['only'=>'index','store']);
Route::resource('service',ServiceController::class);
Route::resource('pickup',PickupController::class);
Route::get('showService','ServiceController@index');
Route::put('updateService/{id}','ServiceController@update');