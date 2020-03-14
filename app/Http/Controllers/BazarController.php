<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use App\Bazar;
use App\Keluar_bazar;
use App\Staff_bazar;
use App\Penjualan_bazar;
use App\Http\Requests\Bazar\CreateRequest;
use App\Http\Requests\Bazar\UpdateRequest;
use App\Http\Requests\Bazar\CreateBarangRequest;
use App\Http\Requests\Bazar\UpdateBarangRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BazarController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::guard()->user();
    }

    public function create(CreateRequest $request)
    {
        Bazar::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Bazar baru berhasil dibuat.'
        ]);
    }

    public function get($id = null)
    {
        if ($id == null) {
            # REPLACE WITH YAJRA
            $bazar = Bazar::withTrashed()->get();

            return DataTables::of($bazar)
                ->addColumn('potongan_harga', function ($bazar) {
                    return number_format($bazar->potongan, 0, '.', ',');
                })
                ->addColumn('aksi', function ($bazar) {
                    if ($bazar->deleted_at == null) {
                        return '
                            <a href="' . route("bazar.kelola-barang", $bazar->id) . '" class="btn btn-sm btn-info" style="margin: 0.25em">Kelola</a>
                            <button class="btn btn-sm btn-warning" value="' . $bazar->id . '" onclick="editBazzar(this.value)" style="margin: 0.25em">Edit</button>
                            <button class="btn btn-sm btn-danger" value="' . $bazar->id . '" onclick="summaryDelete(this.value)" style="margin: 0.25em">Tutup Bazar</button>
                            ';
                    } else {
                        return '
                            Bazar sudah berakhir<br>
                            <a href="' . route("bazzar.laporan", $bazar->id) . '" >Lihat laporan</a>';
                    }
                })
                ->rawColumns(['aksi', 'potongan_harga'])
                ->make(true);
        } else {
            $bazar = Bazar::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $bazar,
            ]);
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        $bazar = Bazar::findOrFail($id);

        $bazar->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data bazar berhasil diubah.'
        ]);
    }

    public function delete($id)
    {
        $bazar = Bazar::findOrFail($id);

        $bazar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bazar berhasil ditutup.'
        ]);
    }

    public function laporan($id_bazar)
    {
        $data_bazar = Bazar::withTrashed()->find($id_bazar);
        $data_barang = Keluar_bazar::where('id_bazar', $id_bazar)->withTrashed()->get(['id_bazar', 'barcode']);
        $data_penjualan = [];

        foreach ($data_barang as $key => $val) {
            $total = Penjualan_bazar::where(
                [
                    'id_bazar' => $id_bazar,
                    'barcode' => $val->barcode
                ]
            )->first(
                DB::raw('sum(jml) as total_penjualan')
            );

            $data_penjualan[$key] = [
                'barcode'                 => $val->barcode,
                'nama_barang'             => $val->include_barang_masuk->namabrg,
                'total_penjualan'         => (int) $total->total_penjualan,
                'potongan_harga'          => $val->include_bazar->potongan,
                'harga_pokok_penjualan'   => $val->include_barang_masuk->hpp,
                'harga_jual_belum_diskon' => $val->include_barang_masuk->hjual,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'data_bazar'     => $data_bazar,
                'data_penjualan' => $data_penjualan
            ]
        ]);
    }

    public function create_staff(Request $request, $id_bazar)
    {
        $data_bazar = Bazar::findOrFail($id_bazar);

        Validator::make(
            $request->all(),
            [
                'username' => 'bail|required|string'
            ],
            [
                'username.required' => 'Kolom username wajib diisi',
                'username.string'   => 'Silahkan pilih username yang tersedia',
            ]
        );

        $staff_sudah_ada = $data_bazar
            ->include_staff_bazar()
            ->where('username', $request->username)
            ->firstOrFail();

        if ($staff_sudah_ada == true) {
            return response()->json([
                'success' => false,
                'message' => 'Staff yang dipilih sudah terdaftar di bazar ini.',
            ], 422);
        } else {
            try {
                $data_bazar
                    ->include_staff_bazar()
                    ->create([
                        'username' => $request->username
                    ]);
            } catch (QueryException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan. Error code: [' . $e->errorInfo[1] . '] ' . $e->errorInfo[2]
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'Staff bazzar ' . $data_bazar->nama_bazar . ' berhasil ditambahkan.',
            ], 200);
        }
    }

    public function get_staff($id_bazar)
    {
        $data_staff_bazzar = Staff_bazar::where(['id_bazar' => $id_bazar])->get();

        return DataTables::of($data_staff_bazzar)
            ->addColumn('alamat', function ($data) {
                return $data->include_user->alamat;
            })
            ->addColumn('telp', function ($data) {
                return $data->include_user->telp;
            })
            ->addColumn('nama_pegawai', function ($data) {
                return $data->include_user->nama;
            })
            ->addColumn('aksi', function ($data) {
                return '<button class="btn btn-sm btn-danger" value="' . $data->username . '" onclick="deleteKelolaStaff(this.value)">Hapus</button>';
            })
            ->rawColumns(['nama_pegawai', 'aksi'])
            ->make(true);
    }

    public function delete_staff($id_bazar, $username)
    {
        $data_bazar = Bazar::findOrfail($id_bazar);

        $data_staff = $data_bazar
            ->include_staff_bazar()
            ->where('username', $username)
            ->firstOrFail();

        try {
            $data_staff->delete();
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Error code: [' . $e->errorInfo[1] . '] ' . $e->errorInfo[2]
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Staff bazzar berhasil dihapus.'
        ]);
    }

    public function create_barang(CreateBarangRequest $request, $id_bazar)
    {
        $data_bazar = Bazar::findOrFail($id_bazar);

        foreach ($request->barcode as $key => $barcode) {
            // Cek stock
            $stock_ready = StockController::get_stock($barcode);
            $stock_sisa = $stock_ready - $request->jumlah[$key];

            if ($stock_sisa < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ada stock barang yang kurang. Mohon cek stock, refresh, dan ulangi kembali.',
                ], 422);
            }

            // Mulai masukan stock
            $data_barang = $data_bazar
                ->include_keluar_bazar()
                ->where('barcode', $barcode)
                ->firstOrFail();

            if ($data_barang == true) {
                return response()->json([
                    'success' => false,
                    'message' => 'Barang yang anda masukan sudah terdaftar, silahkan lakukan update stock',
                ], 422);
            } else {
                try {
                    $data_barang = $data_bazar
                        ->include_keluar_bazar()
                        ->create([
                            'barcode' => $barcode,
                            'jumlah' => $request->jumlah[$key] ?? null
                        ]);
                } catch (QueryException $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Terjadi kesalahan. Error code: [' . $e->errorInfo[1] . '] ' . $e->errorInfo[2]
                    ], 422);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data barang bazzar berhasil ditambahkan.'
        ]);
    }

    public function get_barang($id_bazar, $barcode = null)
    {
        $data_bazar = Bazar::findOrFail($id_bazar);

        if ($barcode == null) {
            $data_barang = $data_bazar
                ->include_keluar_bazar()
                ->groupBy('barcode')
                ->get('barcode');

            $daftar_barang = [];
            foreach ($data_barang as $barang) {
                $harga_diskon = $barang->include_barang_masuk->hpp - $data_bazar->potongan;
                $tanggal = new DateTime(
                    Keluar_bazar::where([
                        'id_bazar' => $id_bazar,
                        'barcode' => $barang->barcode,
                    ])->latest('created_at')->firstOrFail()->created_at
                );
                $tanggal->setTimezone(new DateTimeZone('Asia/Makassar'));

                array_push($daftar_barang, [
                    'id_bazar'     => $id_bazar,
                    'barcode'      => $barang->barcode,
                    'nama_barang'  => $barang->include_barang_masuk->namabrg,
                    'jenis_barang' => $barang->include_barang_masuk->include_jenis->nama_jenis,
                    'tipe_barang'  => $barang->include_barang_masuk->include_tipe->nama_tipe,
                    'hpp'          => "Rp. " . number_format($barang->include_barang_masuk->hpp, 0, '.', ','),
                    'hjual'        => "Rp. " . number_format($harga_diskon, 0, '.', ','),
                    'jumlah'       => StockController::get_stock_for_bazar($id_bazar, $barang->barcode),
                    'tanggal'      => $tanggal->format("d-M-Y H:i T"),
                ]);
            }

            return DataTables::of($daftar_barang)
                ->addColumn('aksi', function ($barang) {
                    return $barang['barcode'] . 'Button aksi';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        } else {
            $barang = $data_bazar
                ->include_keluar_bazar()
                ->where('barcode', $barcode)
                ->groupBy('barcode')
                ->firstOrFail('barcode');

            $tanggal = new DateTime(
                Keluar_bazar::where([
                    'id_bazar' => $id_bazar,
                    'barcode' => $barcode,
                ])->latest('created_at')->firstOrFail()->created_at
            );
            $tanggal->setTimezone(new DateTimeZone('Asia/Makassar'));

            $harga_diskon = $barang->include_barang_masuk->hpp - $data_bazar->potongan;

            $data_barang = [
                'id_bazar'     => $id_bazar,
                'barcode'      => $barang->barcode,
                'nama_barang'  => $barang->include_barang_masuk->namabrg,
                'jenis_barang' => $barang->include_barang_masuk->include_jenis->nama_jenis,
                'tipe_barang'  => $barang->include_barang_masuk->include_tipe->nama_tipe,
                'hpp'          => "Rp. " . number_format($barang->include_barang_masuk->hpp, 0, '.', ','),
                'hjual'        => "Rp. " . number_format($harga_diskon, 0, '.', ','),
                'jumlah'       => StockController::get_stock_for_bazar($id_bazar, $barcode),
                'tanggal'      => $tanggal->format("d-M-Y H:i T"),
            ];

            return response()->json([
                'success' => true,
                'data'    => $data_barang,
            ], 200);
        }
    }

    public function update_barang(UpdateBarangRequest $request, $id_bazar, $barcode)
    {
        $data_bazar = Bazar::findOrFail($id_bazar);

        $barang = $data_bazar
            ->include_keluar_bazar()
            ->where('barcode', $barcode)
            ->firstOrFail();

        if ($barang == false) {
            return response()->json([
                'success' => false,
                'message' => 'Barcode belum terdaftar, silahkan melakukan tambah barang bazar.',
            ], 401);
        }

        try {
            $data_bazar->include_keluar_bazar()->create([
                'barcode' => $barcode,
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
            'message' => 'Stock berhasil ditambahkan',
        ], 200);
    }

    public function delete_barang($id_bazar, $barcode)
    {
        $data_bazar = Bazar::findOrFail($id_bazar);

        $daftar_barang_bazar = $data_bazar
            ->include_keluar_bazar()
            ->where('barcode', $barcode)
            ->get();

        foreach ($daftar_barang_bazar as $barang) {
            try {
                $barang->delete();
            } catch (QueryException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan. Error code: [' . $e->errorInfo[1] . '] ' . $e->errorInfo[2]
                ], 422);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Seluruh stock barang ini sudah dihapus dari bazar ini.',
        ], 200);
    }
}
