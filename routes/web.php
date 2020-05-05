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
use App\Detail_penjualan;
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
        $supplier  = Supplier::withTrashed()->get();

        return view('barang.barang', compact('jenis', "tipe", "supplier"));
    })->middleware('webForAdmin');

    Route::get('/bazar', function () {
        return view('bazar.bazar');
    })->middleware('webForAdmin');

    Route::get('/bazar/tambah', function () {
        return view('bazar.tambah-bazar');
    })->middleware('webForAdmin');

    Route::get('/bazar/kelola-barang/{id_bazar}', function ($id_bazar) {
        $barang = Barang_masuk::all();
        $jenis  = Jenis::all();
        $tipe   = Tipe::all();
        $supplier   = Supplier::all();
        $bazar = Bazar::findOrFail($id_bazar);

        return view('bazar.kelola-barang.kelola-barang', compact('bazar', 'barang', 'id_bazar', 'jenis', 'tipe', 'supplier'));
    })->name('bazar.kelola-barang')->middleware('webForAdmin');

    Route::get('/bazar/kelola-staff/{id_bazar}', function ($id_bazar) {
        $nama   = User::where(['role' => 'pegawai'])->get();
        $bazar = Bazar::findOrFail($id_bazar);

        return view('bazar.kelola-staff.kelola-staff', compact('id_bazar', 'bazar', 'nama'));
    })->name('bazar.kelola-staff')->middleware('webForAdmin');

    Route::get('/user', function () {
        return view('user.user');
    })->middleware('webForAdmin');

    Route::get('/supplier', function () {
        return view('supplier.supplier');
    })->middleware('webForAdmin');

    Route::get('/bazar/tambah', function () {
        return view('bazar.tambah-bazar');
    })->middleware('webForAdmin');

    Route::get('/bazar/tambah/barang-keluar', function () {
        return view('bazar.keluar-bazar');
    })->middleware('webForAdmin');

    Route::get('/bazar/laporan/{id}', function ($id) {
        $nama_bazar = Bazar::where('id', $id)->withTrashed()->first()->nama_bazar;
        return view('bazar.laporan.laporan', compact('id', 'nama_bazar'));
    })->name('bazar.laporan')->middleware('webForAdmin');

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
    Route::get('/detil_transaksi/{kode_trx}', function ($kode_trx) {
        return view('penjualan.detil_transaksi', compact('kode_trx'));
    })->name('penjualan.detil_penjualan');

    Route::get('/biaya', function () {
        $bazar = Bazar::get(['id', 'nama_bazar']);
        return view('biaya.biaya', compact('bazar'));
    })->name('biaya')->middleware('webForAdmin');

    Route::get('/laporan', function () {
        return view('laporan.laporan');
    })->name('laporan')->middleware('webForAdmin');
});
