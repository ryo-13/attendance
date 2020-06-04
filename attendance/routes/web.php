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
Route::namespace('Front')->group(function() {
    Auth::routes();
    
    //ログイン認証後
    Route::middleware('auth:user')->group(function() {
        Route::get('home', 'HomeController@index')->name('home');
    });
});

//管理者
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function() {
    //ログイン認証関連
    Auth::routes([
        'register' => false,
        'reset' => false,
        'verify' => false,
    ]);

    //ログイン認証後
    Route::middleware('auth:admin')->group(function() {
        Route::get('home', 'HomeController@index')->name('home');
    });
});