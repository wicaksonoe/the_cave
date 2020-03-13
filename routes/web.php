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

use App\Barang_masuk;
use App\Bazar;
use App\Jenis;
use App\Supplier;
use App\Tipe;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\StockController;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/sandbox/{barcode}', function ($barcode) {
    return StockController::get_stock($barcode);
});

Route::group(['middleware' => ['isAlreadyLogin', 'auth.jwt']], function () {

    Route::get('/', function () {
        return redirect('dashboard');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::get('/barang', function () {
        $jenis = Jenis::withTrashed()->get();
        $tipe  = Tipe::withTrashed()->get();
        $supp  = Supplier::withTrashed()->get();

        return view('barang.barang', compact('jenis', "tipe", "supp"));
    });

    Route::get('/bazzar', function () {
        return view('bazzar.bazzar');
    });

    Route::get('/bazzar/tambah', function () {
        return view('bazzar.tambah-bazzar');
    });

    Route::get('/bazzar/kelola-barang/{id_bazzar}', function ($id_bazzar) {
        $barang = Barang_masuk::all();
        $jenis  = Jenis::all();
        $tipe   = Tipe::all();
        $supp   = Supplier::all();
        $bazzar = Bazar::findOrFail($id_bazzar);

        return view('bazzar.kelola-barang.kelola-barang', compact('bazzar', 'barang', 'id_bazzar', 'jenis', 'tipe', 'supp'));
    })->name('bazzar.kelola-barang');

    Route::get('/bazzar/kelola-staff/{id_bazzar}', function ($id_bazzar) {
        $nama   = User::where(['role' => 'pegawai'])->get();
        $bazzar = Bazar::findOrFail($id_bazzar);

        return view('bazzar.kelola-staff.kelola-staff', compact('id_bazzar', 'bazzar', 'nama'));
    })->name('bazzar.kelola-staff');

    Route::get('/bazzar/laporan/{id_bazar}', 'BazarController@laporan')
        // function ($id_bazzar) {
        //     return $id_bazzar;
        // })
        ->name('bazzar.laporan');


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

    Route::post('/logout', function (Request $request) {
        Cookie::forget('access_token');
        Auth::guard()->logout();
        return redirect()->route('login');
    });

    Route::get('/transaksi_baru', function () {
        return view('penjualan.transaksi_baru');
    });
    Route::get('/riwayat_transaksi', function () {
        return view('penjualan.riwayat_transaksi');
    });
});
