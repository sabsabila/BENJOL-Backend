<?php

use App\Http\Controllers\BengkelController;
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

Route::resource('bengkel', BengkelController::class);
Route::get('bengkel', 'BengkelController@index');
Route::post('bengkel', 'BengkelController@create');
Route::get('/bengkel/{id}', 'BengkelController@detail');
Route::put('/bengkel/{id}', 'BengkelController@update');
Route::delete('/bengkel/{id}', 'BengkelController@delete');

Route::resource('motorcycle', MotorcycleController::class);
Route::get('motorcycle', 'MotorcycleController@index');
Route::post('motorcycle', 'MotorcycleController@store');
Route::put('/motorcycle/{id}', 'MotorcycleController@update');
Route::delete('/motorcycle/{id}', 'MotorcycleController@destroy');