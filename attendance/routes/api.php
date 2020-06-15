<?php

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

Route::middleware('auth:api')->namespace('Front\Api')->name('api.')->group(function () {
    Route::get('attendances', 'AttendanceController@index')->name('attendances.index');
    Route::post('attendances', 'AttendanceController@store')->name('attendances.store');
    Route::put('attendances/{attendance}', 'AttendanceController@update')->name('attendances.update');
    Route::delete('attendances/{attendance}', 'AttendanceController@delete')->name('attendances.delete');
});
