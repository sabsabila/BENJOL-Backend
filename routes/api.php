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

Route::get('bengkel', 'App\Http\Controllers\BengkelController@index');
Route::post('bengkel', 'App\Http\Controllers\BengkelController@create');
Route::get('/bengkel/{id}', 'App\Http\Controllers\BengkelController@detail');
Route::put('/bengkel/{id}', 'App\Http\Controllers\BengkelController@update');
Route::delete('/bengkel/{id}', 'App\Http\Controllers\BengkelController@delete');