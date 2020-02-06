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

use App\Jenis;
use App\Supplier;
use App\Tipe;

Route::get('/', function () {
    return view('welcome');
})->middleware(['isAlreadyLogin', 'auth.jwt']);

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/barang', function () {
    $jenis = Jenis::all();
    $tipe = Tipe::all();
    $supp = Supplier::all();

    return view('barang.barang', compact('jenis',"tipe","supp"));
});

Route::get('/bazzar', function () {
    return view('bazzar.bazzar');
});

Route::get('/user', function () {
    return view('user.user');
});

Route::get('/supplier', function () {
    return view('supplier.supplier');
});

Route::get('/bazzar/tambah', function () {
    return view('bazzar.tambah-bazzar');
});

Route::get('/bazzar/tambah/barang-keluar', function () {
    return view('bazzar.keluar-bazzar');
});

Route::get('/register', function () {
		return view('auth.register');
});

Route::get('/login', function () {
		return view('auth.login');
})->name('login');
