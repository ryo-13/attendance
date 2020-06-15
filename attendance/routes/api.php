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

Route::middleware('auth:api')->namespace('Front\API')->group(function () {
    // 作業者
    Route::get('identity', 'IdentityController@show')->name('api.identity.show');
    Route::post('identity/confirm-password', 'IdentityController@confirmPassword')->name('api.identity.confirmPassword');
    Route::put('identity', 'IdentityController@update')->name('api.identity.update');

    // 出退勤
    Route::get('attendances', 'AttendanceController@index')->name('attendances.index');
    Route::post('attendances', 'AttendanceController@store')->name('attendances.store');
    Route::put('attendances/{attendance}', 'AttendanceController@update')->name('attendances.update');
    Route::delete('attendances/{attendance}', 'AttendanceController@delete')->name('attendances.delete');
});
