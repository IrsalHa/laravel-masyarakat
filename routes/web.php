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

Route::group(['prefix' => 'api/petugas','middleware' => 'auth:petugas'], function(){
    Route::get('/pengaduan/get', 'PengaduanController@index_all')->name('pengaduan.index.all');
    Route::post('/tanggapan/delete', 'TanggapanController@delete')->name('tanggapan.delete');
    Route::post('/tanggapan/create', 'TanggapanController@tanggapi')->name('tanggapan.create');
    Route::get('/user/get', 'UserController@get_UserNon')->name('user.index.non');
    Route::post('/user/verif', 'UserController@verif')->name('user.verif');
    Route::get('/petugas/get', 'PetugasController@get_Petugas')->name('petugas.index');

});

Route::group(['prefix' => 'api','middleware' => 'auth:web'], function(){
    Route::get('/pengaduan/get', 'PengaduanController@index')->name('pengaduan.index');
    Route::get('/user/ini', 'UserController@get_ini')->name('user.ini');
    Route::post('/pengaduan/update', 'PengaduanController@update')->name('pengaduan.update');
    Route::post('/pengaduan/delete', 'PengaduanController@delete')->name('pengaduan.delete');
    Route::post('/pengaduan/buat', 'PengaduanController@buat')->name('pengaduan.buat');
});



Route::group(['prefix' => 'petugas'], function(){
    Route::post('/verif/user', 'UserController@verif')->name('petugas.user.verif');
    Route::post('/pengaduan/delete', 'PengaduanController@delete_pengaduan')->name('petugas.pengaduan.delete');
   
    Route::post('/login', 'AuthPetugas\LoginController@login')->name('petugas.login.submit');
    Route::get('/login', 'AuthPetugas\LoginController@showLoginForm')->name('petugas.login');
    Route::get('/', 'AdminController@index')->where('any','.*')->name('petugas.home');
});