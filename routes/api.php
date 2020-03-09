<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'v1',
    'middleware' => 'api'
], function () {
    Route::post('login', 'APIController@login');
    Route::post('register', 'APIController@register');
    Route::get('logout', 'APIController@logout');
    Route::get('home', 'APIController@home');

    Route::group([
        'prefix' => 'barang',
        'middleware' => 'auth:api',
    ], function () {
        Route::post('/', 'BarangController@create');
        Route::get('/', 'BarangController@get');
        Route::get('/{barcode}', 'BarangController@get');
        Route::put('/{barcode}', 'BarangController@update');
        Route::delete('/{barcode}', 'BarangController@delete');

        Route::get('/stock/{barcode}', 'BarangController@get_stock');
        Route::put('/stock/{id}', 'BarangController@update_stock');
        Route::delete('/stock/{id}', 'BarangController@delete_stock');
    });

    Route::group([
        'prefix' => 'supplier',
        'middleware' => 'auth:api',
    ], function () {
        Route::post('/', 'SupplierController@create');
        Route::get('/', 'SupplierController@get');
        Route::get('/{id}', 'SupplierController@get');
        Route::put('/{id}', 'SupplierController@update');
        Route::delete('/{id}', 'SupplierController@delete');
    });

    Route::group([
        'prefix' => 'bazzar',
        'middleware' => 'auth:api',
    ], function () {
        Route::post('/', 'BazarController@create');
        Route::get('/', 'BazarController@get');
        Route::get('/{id}', 'BazarController@get');
        Route::put('/{id}', 'BazarController@update');
        Route::delete('/{id}', 'BazarController@delete');

        Route::group([
            'prefix' => 'staff'
        ], function () {
            Route::post('/{id_bazzar}', 'BazarController@create_staff');
            Route::get('/{id_bazzar}', 'BazarController@get_staff');
            Route::delete('/{id_bazzar}/{username}', 'BazarController@delete_staff');
        });

        Route::group([
            'prefix' => 'barang'
        ], function () {
            Route::post('/{id_bazzar}', 'BazarController@create_barang');
            Route::get('/{id_bazzar}', 'BazarController@get_barang');
            Route::get('/{id_bazzar}/{id}', 'BazarController@get_barang');
            Route::put('/{id_bazzar}/{id}', 'BazarController@update_barang');
            Route::delete('/{id_bazzar}/{id}', 'BazarController@delete_barang');
        });

        Route::group([
            'prefix' => 'penjualan',
        ], function () {
            Route::post('/', 'PenjualanBazarController@create');
            Route::get('/', 'PenjualanBazarController@get');
            Route::get('/{id}', 'PenjualanBazarController@get');
            Route::put('/{id}', 'PenjualanBazarController@update');
            Route::delete('/{id}', 'PenjualanBazarController@delete');
        });
    });

    Route::group([
        'prefix' => 'users',
        'middleware' => 'auth:api'
    ], function () {
        Route::post('/', 'UserController@create');
        Route::get('/', 'UserController@get');
        Route::get('/{username}', 'UserController@get');
        Route::put('/{username}', 'UserController@update');
    });

    Route::group([
        'prefix' => 'penjualan',
        'middleware' => 'auth:api'
    ], function () {
        Route::post('/', 'PenjualanController@create'); // posting penjualan baru
        Route::get('/', 'PenjualanController@get'); // daftar history penjualan
        Route::get('/{kode_trx}', 'PenjualanController@get');   // detail barang transaksi
        Route::put('/retur/{kode_trx}', 'PenjualanController@retur_barang');
        Route::get('/laporan/{kode_trx}', 'PenjualanController@laporan_trx');
    });
});
