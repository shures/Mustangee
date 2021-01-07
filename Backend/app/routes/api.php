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

Route::group(['prefix' => 'admin'], function() {
    Route::post('/', 'App\Http\Controllers\Admin\AuthController@login');
//    Route::post('/some', 'App\Http\Controllers\Admin\AuthController@upload')->middleware('auth:sanctum');
    Route::post('/add_location', 'App\Http\Controllers\Admin\ContentController@add_location');
});
