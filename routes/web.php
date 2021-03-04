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

Route::post('/loginuser', 'Auth\LoginController@login')->name('logina');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'petugas'], function(){
    Route::post('/verif/user', 'UserController@verif')->name('petugas.user.verif');
    Route::post('/pengaduan/delete', 'PengaduanController@delete_pengaduan')->name('petugas.pengaduan.delete');
    Route::post('/login', 'AuthPetugas\LoginController@login')->name('petugas.login.submit');
    Route::get('/login', 'AuthPetugas\LoginController@showLoginForm')->name('petugas.login');
    Route::get('/', 'AdminController@index')->where('any','.*')->name('petugas.home');
});