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
    // 残業申請
    Route::get('overtimes', 'OvertimeController@getOvertimes')->name('api.overtimes.getOvertimes');
    Route::post('overtimes', 'OvertimeController@store')->name('api.overtimes.store');
    Route::delete('overtimes/{overtime}', 'OvertimeController@destroy')->name('api.overtimes.destroy');
    // 出退勤
    Route::get('attendances', 'AttendanceController@getAttendances')->name('api.attendances.getAttendances');
    Route::post('attendances', 'AttendanceController@storeAttendances')->name('api.attendances.storeAttendances');
    Route::put('attendances/{attendance}', 'AttendanceController@updateAttendances')->name('api.attendances.updateAttendances');
    Route::delete('attendances/{attendance}', 'AttendanceController@delete')->name('api.attendances.delete');
    //遅刻
    Route::get('video-chat', 'VideoChatController@index')->name('api.videoChat.index');
});
