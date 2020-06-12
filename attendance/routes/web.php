<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'home');
Route::redirect('/admin', 'admin/home');

//フロント
Route::namespace('Front')->group(function () {
    Auth::routes();

    //ログイン認証後
    Route::middleware('auth:user')->group(function () {
        Route::get('home', 'HomeController@index')->name('home');

        // 出退勤
       // Route::get('attendances', 'AttendanceController@index')->name('attendances.index');
    });
});

//管理者
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    //ログイン認証関連
    Auth::routes([
        'register' => false,
        'reset' => false,
        'verify' => false,
    ]);

    //ログイン認証後
    Route::middleware('auth:admin')->group(function () {
        Route::get('home', 'HomeController@index')->name('home');

        // 出退勤
        Route::get('attendances', 'AttendanceController@index')->name('attendances.index');
        Route::get('attendances/{user}/edit', 'AttendanceController@edit')->name('attendances.edit');

        // 作業者
        Route::get('users', 'UserController@index')->name('users.index');
        Route::get('users/create', 'UserController@create')->name('users.create');
        Route::post('users/store','UserController@store')->name('users.store');
        Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
        Route::post('users/{user}/update','UserController@update')->name('users.update');
        Route::delete('users/{user}/destroy','UserController@destroy')->name('users.destroy');

        // 残業時間申請
        Route::get('overtimes', 'OverTimeController@index')->name('overtimes.index');
        Route::get('{user}/overtimes/update', 'OvertimeController@update')->name('overtimes.update');
    });
});
