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
    Route::get('check', 'APIController@check');
    Route::get('logout', 'APIController@logout');

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

    Route::post('/jenis', 'JenisController@create')->middleware('auth:api');
    Route::post('/tipe', 'TipeController@create')->middleware('auth:api');

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
        'prefix' => 'bazar',
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
            Route::post('/{id_bazar}', 'BazarController@create_staff');
            Route::get('/{id_bazar}', 'BazarController@get_staff');
            Route::delete('/{id_bazar}/{username}', 'BazarController@delete_staff');
        });

        Route::group([
            'prefix' => 'barang'
        ], function () {
            Route::post('/{id_bazar}', 'BazarController@create_barang');
            Route::get('/{id_bazar}', 'BazarController@get_barang');
            Route::get('/{id_bazar}/{barcode}', 'BazarController@get_barang');
            Route::put('/{id_bazar}/{barcode}', 'BazarController@update_barang');
            Route::delete('/{id_bazar}/{barcode}', 'BazarController@delete_barang');
        });

        Route::group([
            'prefix' => 'penjualan',
        ], function () {
            Route::post('/{id_bazar}', 'PenjualanBazarController@create');
            Route::get('/{id_bazar}', 'PenjualanBazarController@get');
            Route::get('/{id_bazar}/{kode_trx}', 'PenjualanBazarController@get');
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

    Route::group([
        'prefix' => 'biaya',
        'middleware' => 'auth:api'
    ], function () {
        Route::post('/', 'BiayaController@create');
        Route::get('/', 'BiayaController@get');
        Route::get('/{id}', 'BiayaController@get');
        Route::put('/{id}', 'BiayaController@update');
        Route::delete('/{id}', 'BiayaController@delete');

        Route::post('/bazar/{id_bazar}', 'BiayaController@create_biaya_bazar');
        Route::get('/bazar/{id_bazar}', 'BiayaController@get_biaya_bazar');
        Route::get('/bazar/{id_bazar}/{id}', 'BiayaController@get_biaya_bazar');
        Route::put('/bazar/{id_bazar}/{id}', 'BiayaController@update_biaya_bazar');
        Route::delete('/bazar/{id_bazar}/{id}', 'BiayaController@delete_biaya_bazar');
    });

    Route::group([
        'prefix' => 'laporan',
        'middleware' => 'auth:api'
    ], function () {
        Route::get('terlaris/{bulan}/{tahun}/{param}', 'LaporanController@terlaris');
        Route::get('penjualan/bazar/{id}', 'LaporanController@penjualan_bazar');
        Route::get('penjualan/{bulan}/{tahun}', 'LaporanController@penjualan');
    });
});
