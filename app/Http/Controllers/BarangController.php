<?php

namespace App\Http\Controllers;

use App\Barang_masuk;
use App\Detail_barang;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Http\Requests\BarangMasuk\CreateRequest;
use App\Http\Requests\BarangMasuk\UpdateRequest;
use DateTime;
use DateTimeZone;

class BarangController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::guard()->user();
        $this->middleware('isRoleAdmin', ['except' => ['get', 'get_stock']]);
    }

    public function get($barcode = null)
    {
        $data = [];

        if ($barcode == null) {
            // UPDATE USING YAJRA
            $data_barang = Barang_masuk::all();

            foreach ($data_barang as $key => $value) {
                $tanggal = new DateTime(
                    Detail_barang::where('barcode_barang', $value->barcode)
                        ->latest('created_at')
                        ->first()
                        ->created_at
                );
                $tanggal->setTimezone(new DateTimeZone('Asia/Makassar'));

                $data[$key] = [
                    'barcode'         => $value->barcode,
                    'namabrg'         => $value->namabrg,
                    'jenis_barang'    => $value->include_jenis->nama_jenis,
                    'tipe_barang'     => $value->include_tipe->nama_tipe,
                    'supplier_barang' => $value->include_supplier->nama_supplier,
                    'jumlah'          => StockController::get_stock($value->barcode),
                    'hpp'             => 'Rp. ' . number_format($value->hpp, 0, '.', ','),
                    'hjual'           => 'Rp. ' . number_format($value->hjual, 0, '.', ','),
                    'grosir'          => 'Rp. ' . number_format($value->grosir, 0, '.', ','),
                    'partai'          => 'Rp. ' . number_format($value->partai, 0, '.', ','),
                    'tanggal'         => $tanggal->format("d-M-Y H:i T"),
                ];
            }
            return DataTables::of($data)
                ->addColumn('aksi', function ($data_barang) {
                    $data_barang = (object) $data_barang;
                    return '<button class="btn btn-sm btn-info" value="' . $data_barang->barcode . '" onclick="editBarang(this.value)">Edit</button>
                            <button class="btn btn-sm btn-danger" value="' . $data_barang->barcode . '" onclick="deleteBarang(this.value)">Delete</button>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        } else {
            $data = Barang_masuk::findOrFail($barcode);

            $tanggal = new DateTime(
                Detail_barang::where('barcode_barang', $data->barcode)
                    ->latest('created_at')
                    ->first()
                    ->created_at
            );
            $tanggal->setTimezone(new DateTimeZone('Asia/Makassar'));

            $data_barang = [
                'barcode'  => $data->barcode,
                'namabrg'  => $data->namabrg,
                'id_jenis' => $data->id_jenis,
                'id_tipe'  => $data->id_tipe,
                'id_sup'   => $data->id_sup,
                'jumlah'   => StockController::get_stock($data->barcode),
                'hpp'      => number_format($data->hpp, 0, '.', ','),
                'hjual'    => number_format($data->hjual, 0, '.', ','),
                'grosir'   => number_format($data->grosir, 0, '.', ','),
                'partai'   => number_format($data->partai, 0, '.', ','),
                'tanggal'  => $tanggal->format("d-M-Y H:i T"),
            ];

            return response()->json([
                'success' => true,
                'data' => $data_barang
            ]);
        }
    }

    public function get_stock($barcode)
    {
        $daftar_stock = Detail_barang::where('barcode_barang', $barcode)->get();

        return DataTables::of($daftar_stock)
            ->addColumn('aksi', function ($parm) {
                return '<button class="btn btn-sm btn-info" value="' . $parm->id . '" onclick="editStock(this.value)">Edit</button>
                        <button class="btn btn-sm btn-danger" value="' . $parm->id . '" onclick="deleteStock(this.value)">Delete</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function update_stock($id, Request $request)
    {
        $rules = [
            'jumlah' => 'bail|required|numeric|min:0'
        ];

        $messages = [
            'jumlah.required' => 'Kolom jumlah barang tidak boleh kosong',
            'jumlah.numeric' => 'Kolom jumlah barang harus berupa angka',
            'jumlah.min' => 'Kolom jumlah barang tidak boleh kurang dari 0',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        $data_stock = Detail_barang::findOrFail($id);

        try {

            Detail_barang::create([
                'barcode' => $data_stock->barcode_barang,
                'jumlah' => $request->jumlah,
            ]);

            $data_stock->delete();
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Error code: [' . $e->errorInfo[1] . '] ' . $e->errorInfo[2]
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data stock berhasil diupdate.'
        ], 200);
    }

    public function delete_stock($id)
    {
        $data_stock = Detail_barang::findOrFail($id);

        try {
            $data_stock->delete();
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Error code: [' . $e->errorInfo[1] . '] ' . $e->errorInfo[2]
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data stock berhasil dihapus.'
        ], 200);
    }

    public function create(CreateRequest $request)
    {
        try {
            $barang = Barang_masuk::create([
                'barcode'  => $request->barcode,
                'namabrg'  => $request->namabrg,
                'id_jenis' => $request->id_jenis,
                'id_tipe'  => $request->id_tipe,
                'id_sup'   => $request->id_sup,
                'hpp'      => $request->hpp,
                'hjual'    => $request->hjual,
                'grosir'   => $request->grosir,
                'partai'   => $request->partai,
            ]);

            $barang->include_detail_barang()->create([
                'jumlah' => $request->jumlah,
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Error code: [' . $e->errorInfo[1] . '] ' . $e->errorInfo[2]
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Barang baru berhasil dimasukan'
        ]);
    }

    public function update(UpdateRequest $request, $barcode)
    {
        $barang = Barang_masuk::findOrFail($barcode);

        $stock_asal = StockController::get_stock($barang->barcode);

        $selisih = $request->jumlah - $stock_asal;

        if ($selisih < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah barang tidak boleh lebih sedikit.'
            ], 422);
        }

        try {
            $barang->update([
                'namabrg'  => $request->namabrg,
                'id_jenis' => $request->id_jenis,
                'id_tipe'  => $request->id_tipe,
                'id_sup'   => $request->id_sup,
                'hpp'      => $request->hpp,
                'hjual'    => $request->hjual,
                'grosir'   => $request->grosir,
                'partai'   => $request->partai,
            ]);

            $barang
                ->include_detail_barang()
                ->create([
                    'jumlah' => $selisih
                ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Error code: [' . $e->errorInfo[1] . '] ' . $e->errorInfo[2]
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data barang berhasil diubah'
        ]);
    }

    public function delete($barcode)
    {
        $data = Barang_masuk::findOrFail($barcode);

        try {
            $data->include_detail_barang()->delete();
            $data->delete();
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Error code: [' . $e->errorInfo[1] . '] ' . $e->errorInfo[2]
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data barang berhasil dihapus'
        ]);
    }
}
