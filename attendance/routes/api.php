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
    Route::put('attendances/update_arrival/{attendance}', 'AttendanceController@updateArrival')->name('api.attendances.updateArrival');
    Route::put('attendances/update_leave/{attendance}', 'AttendanceController@updateLeave')->name('api.attendances.updateLeave');
    Route::put('attendances/reset_arrival/{attendance}', 'AttendanceController@resetArrival')->name('api.attendances.resetArrival');
    Route::put('attendances/reset_leave/{attendance}', 'AttendanceController@resetLeave')->name('api.attendances.resetLeave');
    //遅刻
    Route::get('video-chat', 'VideoChatController@getDataForPusher')->name('api.videoChat.getDataForPusher');
    Route::post('auth/video-chat', 'VideoChatController@auth')->name('api.videoChat.auth');
});
