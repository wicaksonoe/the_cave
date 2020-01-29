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

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/barang', function () {
    return view('barang');
});

Route::get('/bazzar', function () {
    return view('bazzar');
});

Route::get('/user', function () {
    return view('user');
});

Route::get('/supplier', function () {
    return view('supplier');
});

Route::get('/bazzar/tambah', function () {
    return view('tambah-bazzar');
});

Route::get('/bazzar/tambah/barang-keluar', function () {
    return view('keluar-bazzar');
});

Route::get('/register', function () {
		return view('auth.register');
});

Route::get('/login', function () {
		return view('auth.login0');
});
