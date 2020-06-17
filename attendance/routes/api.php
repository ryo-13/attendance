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

Route::middleware('auth:api')->namespace('Front\API')->group(function() {
    Route::get('identity', 'IdentityController@show')->name('api.identity.show');
    Route::post('identity/confirm-password', 'IdentityController@confirmPassword')->name('api.identity.confirmPassword');
    Route::put('identity', 'IdentityController@update')->name('api.identity.update');

    Route::get('overtimes', 'OvertimeController@getOvertimes')->name('api.overtime.getOvertimes');
    Route::post('overtimes', 'OvertimeController@store')->name('api.overtime.store');
});
