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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function(){
    Route::get('/', 'LoginController@showLoginForm')->name('admin.showLoginForm');
    Route::post('/', 'LoginController@login')->name('admin.login');
    Route::group(['middleware' => 'auth:admin'], function(){
        Route::get('/home', 'AdminController@index')->name('admin.home');
        Route::post('/logout', 'LoginController@logout')->name('admin.logout');
    });
});

Route::get('/home', 'HomeController@index')->name('home');
