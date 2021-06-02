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

// Admin Capabilities...
Route::group(['middleware' => ['admin']], function(){
	
	// Logout
	Route::get('/admin/logout', function(){
	    return redirect('/');
	});
	Route::post('/admin/logout', 'Auth\LoginController@logout');

	// Dashboard
	Route::get('/admin', 'DashboardController@index');

	// Profil
	Route::get('/admin/profil', 'UserController@profile');
	Route::post('/admin/profil/update', 'UserController@update_profile');

	// User
	Route::get('/admin/user', 'UserController@index');
	Route::get('/admin/user/create', 'UserController@create');
	Route::post('/admin/user/store', 'UserController@store');
	Route::get('/admin/user/detail/{id}', 'UserController@detail');
	Route::get('/admin/user/export', 'UserController@export');
	Route::post('/admin/user/import', 'UserController@import');
	Route::get('/admin/user/edit/{id}', 'UserController@edit');
	Route::post('/admin/user/update', 'UserController@update');
	Route::post('/admin/user/delete', 'UserController@delete');

	// Pengaturan
	Route::get('/admin/pengaturan', 'SettingController@index');
	Route::post('/admin/pengaturan/update', 'SettingController@update');

	// Stok
	Route::get('/admin/stok', 'StokController@index');
	Route::post('/admin/stok/update', 'StokController@update');

	// Grup
	Route::get('/admin/grup', 'GrupController@index');
	Route::get('/admin/grup/create', 'GrupController@create');
	Route::post('/admin/grup/store', 'GrupController@store');
	Route::get('/admin/grup/export', 'GrupController@export');
	Route::get('/admin/grup/edit/{id}', 'GrupController@edit');
	Route::post('/admin/grup/update', 'GrupController@update');
	Route::post('/admin/grup/delete', 'GrupController@delete');

	// Kantor
	Route::get('/admin/kantor', 'KantorController@index');
	Route::get('/admin/kantor/create', 'KantorController@create');
	Route::post('/admin/kantor/store', 'KantorController@store');
	Route::get('/admin/kantor/export', 'KantorController@export');
	Route::get('/admin/kantor/edit/{id}', 'KantorController@edit');
	Route::post('/admin/kantor/update', 'KantorController@update');
	Route::post('/admin/kantor/delete', 'KantorController@delete');

	// Barang
	Route::get('/admin/barang', 'BarangController@index');
	Route::get('/admin/barang/create', 'BarangController@create');
	Route::post('/admin/barang/store', 'BarangController@store');
	Route::get('/admin/barang/export', 'BarangController@export');
	Route::get('/admin/barang/edit/{id}', 'BarangController@edit');
	Route::post('/admin/barang/update', 'BarangController@update');
	Route::post('/admin/barang/delete', 'BarangController@delete');
	Route::get('/admin/barang/json-kantor/{id}', 'BarangController@json_kantor');
});

// Guest Capabilities...
Route::group(['middleware' => ['guest']], function(){

	// Home
	Route::get('/', function(){
		return redirect('/login');
	});

	// Login dan Recovery Password
	Route::get('/login', 'Auth\LoginController@showLoginForm');
	Route::post('/login', 'Auth\LoginController@login');
	Route::get('/recovery-password', 'Auth\LoginController@showRecoveryPasswordForm');
	Route::post('/recovery-password', 'Auth\LoginController@recoveryPassword');
});