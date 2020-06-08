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
    Route::get('identity', 'UserController@show')->name('api.identity.show');
    Route::put('identity', 'UserController@update')->name('api.identity.update');
});
