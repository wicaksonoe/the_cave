<?php

namespace App\Http\Controllers;

use App\Barang_masuk;
use App\Bazar;
use App\Http\Requests\BazarRequest;
use App\Http\Requests\KeluarBazzarRequest;
use App\Keluar_bazar;
use App\Staff_bazar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BazarController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::guard()->user();
    }

    public function create(BazarRequest $request)
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
            $bazar = Bazar::all();

            return DataTables::of($bazar)
                ->addColumn('aksi', function ($bazar) {
                    return '
                        <a href="' . route("bazzar.kelola-barang", $bazar->id) . '" class="btn btn-sm btn-info">Kelola</a>
                        <button class="btn btn-sm btn-warning" value="' . $bazar->id . '" onclick="editBazzar(this.value)">Edit</button>
                        ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        } else {
            $bazar = Bazar::findOrFail($id);
        }

        return response()->json([
            'success' => true,
            'data' => $bazar,
        ]);
    }

    public function update(BazarRequest $request, $id)
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

        $barang_bazzar = $bazar->include_keluar_bazar()->get();

        foreach ($barang_bazzar as $value) {
            $return_stock = $this->kembalikan_stock($value->barcode, $value->jml);

            if ($return_stock == false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan, silahkan ulangi lagi.'
                ], 422);
            }

            $value->delete();
        }

        $bazar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data bazar berhasil dihapus.'
        ]);
    }

    public function create_staff(Request $request, $id_bazzar)
    {
        $data_bazzar = Bazar::findOrFail($id_bazzar);

        $validateRequest = $request->validate([
            'username' => 'required|string'
        ]);

        Staff_bazar::create([
            'id_bazar' => $id_bazzar,
            'username' => $request->username
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Staff bazzar ' . $data_bazzar->nama_bazar . ' berhasil ditambahkan.'
        ]);
    }

    public function get_staff($id_bazzar)
    {
        $data_staff_bazzar = Staff_bazar::where(['id_bazar' => $id_bazzar])->get();

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
                return '<button class="btn btn-sm btn-danger" value="' . $data->username . '" onclick="deleteStaff(this.value)">Hapus</button>';
            })
            ->rawColumns(['nama_pegawai', 'aksi'])
            ->make(true);
    }

    public function delete_staff($id_bazzar, $username)
    {
        $data_staff = Staff_bazar::where([
            'id_bazar' => $id_bazzar,
            'username' => $username
        ])->first();

        if ($data_staff) {
            $data_staff->delete();

            return response()->json([
                'success' => true,
                'message' => 'Staff bazzar berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Staff bazzar tidak ditemukan atau sudah terhapus.'
            ], 404);
        }
    }

    public function create_barang(KeluarBazzarRequest $request, $id_bazzar)
    {
        if (gettype((int) $id_bazzar) != 'integer') {
            return response()->json([
                'success' => false,
                'message' => 'Mohon masukan id_bazzar dengan benar.'
            ], 422);
        }

        $validatedRequest = $request->validated();

        $data_exist = Keluar_bazar::where([
            'id_bazar' => $id_bazzar,
            'barcode' => $request->barcode
        ])->first();


        if ($data_exist) {
            return response()->json([
                'success' => false,
                'message' => 'Data barang untuk bazzar ini sudah ada. Silahkan ubah jumlah barang saja.'
            ], 422);
        } else {
            $cek_stock = $this->kurangi_stock($request->barcode, $request->jml);

            if (!$cek_stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock barang di gudang kurang dari jumlah yang diminta.'
                ], 422);
            }

            Keluar_bazar::create([
                'id_bazar' => $id_bazzar,
                'date'     => $request->date,
                'barcode'  => $request->barcode,
                'jml'      => $request->jml,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data barang bazzar berhasil ditambahkan.'
            ]);
        }
    }

    public function get_barang($id_bazzar, $id = null)
    {
        $data_barang = [];
        $keluar_bazar = Keluar_bazar::where(['id_bazar' => $id_bazzar])->withTrashed()->get();

        if ($keluar_bazar) {
            if ($id == null) {

                foreach ($keluar_bazar as $key => $value) {
                    $hjual_asli = $value->include_barang_masuk->hjual;
                    $potongan = $value->include_bazar->potongan;
                    $hjual_setelah_diskon = $hjual_asli - ($hjual_asli * ($potongan / 100));

                    $data_barang[$key] = [
                        'id'           => $value->id,
                        'id_bazar'     => $value->id_bazar,
                        'nama_barang'  => $value->include_barang_masuk->namabrg,
                        'jenis_barang' => $value->include_barang_masuk->include_jenis->nama_jenis,
                        'tipe_barang'  => $value->include_barang_masuk->include_tipe->nama_tipe,
                        'hpp'          => $value->include_barang_masuk->hpp,
                        'hjual'        => $hjual_setelah_diskon,
                        'jumlah'       => $value->jml,
                        'date'         => $value->date,
                    ];
                }

                return DataTables::of($data_barang)
                    ->addColumn('aksi', function ($data_barang) {
                        $data_barang = (object) $data_barang;
                        return '
                            <button class="btn btn-sm btn-info" value="' . $data_barang->id . '" onclick="editKelolaBarang(this.value)">Edit</button>
                            <button class="btn btn-sm btn-danger" value="' . $data_barang->id . '" onclick="deleteKelolaBarang(this.value)" style="margin-left:1rem">Hapus</button>
                            ';
                    })
                    ->rawColumns(['aksi'])
                    ->make(true);
            } else {
                $data = Keluar_bazar::find($id);

                return response()->json([
                    'success' => true,
                    'data' => $data
                ]);
            }
        }
    }

    public function update_barang(Request $request, $id_bazzar, $id)
    {
        $validatedRequest = $request->validate([
            'jml' => 'required|integer'
        ]);

        $bazzar_exist = Bazar::findOrFail($id_bazzar);

        if ($bazzar_exist) {
            $barang_bazzar_exist = Keluar_bazar::findOrFail($id);

            if ($barang_bazzar_exist) {
                /*
                cek jumlah input lebih atau kurang dari value sebelumnya
                kalau lebih dari = cari selisihnya, lalu ambil barang dari gudang sesuai selisih
                kalau kurang dari = cari selsihnya, lalu kembalikan barang ke gudang sesuai selisih
                */

                $jumlah_sebelumnya = $barang_bazzar_exist->jml;

                if ($request->jml > $jumlah_sebelumnya) {
                    $selisih = $request->jml - $jumlah_sebelumnya;

                    $cek_stock = $this->kurangi_stock($request->barcode, $selisih);

                    if (!$cek_stock) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Stock barang di gudang kurang dari jumlah yang diminta.'
                        ], 422);
                    } else {
                        $barang_bazzar_exist->update([
                            'jml' => $jumlah_sebelumnya + $selisih
                        ]);
                    }
                } else if ($request->jml < $jumlah_sebelumnya) {
                    $selisih = $jumlah_sebelumnya - $request->jml;

                    $cek_stock = $this->kembalikan_stock($request->barcode, $selisih);

                    if (!$cek_stock) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Terjadi kesalahan.'
                        ], 422);
                    } else {
                        $barang_bazzar_exist->update([
                            'jml' => $jumlah_sebelumnya - $selisih
                        ]);
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Data barang bazzar berhasil diubah.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data barang bazzar yang anda minta tidak terdaftar, atau sudah terhapus.'
                ], 404);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data bazzar yang anda minta tidak terdaftar, atau sudah terhapus.'
            ], 404);
        }
    }

    public function delete_barang($id_bazzar, $id)
    {
        $bazzar_exist = Bazar::findOrFail($id_bazzar);

        if ($bazzar_exist) {
            $data_barang_bazzar = Keluar_bazar::findOrFail($id);

            $cek_stock = $this->kembalikan_stock($data_barang_bazzar->barcode, $data_barang_bazzar->jml);

            if (!$cek_stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data barang yang anda minta tidak terdaftar, atau sudah terhapus.'
                ], 422);
            }

            $data_barang_bazzar->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data barang bazzar berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data bazzar yang anda minta tidak terdaftar, atau sudah terhapus.'
            ], 404);
        }
    }

    protected function kurangi_stock($barcode, $jml)
    {
        $data_barang = Barang_masuk::findOrFail($barcode);

        if ($data_barang->jumlah - $jml >= 0) {
            $data_barang->update([
                'jumlah' => $data_barang->jumlah - $jml
            ]);

            return true;
        } else {
            return false;
        }
    }

    protected function kembalikan_stock($barcode, $jml)
    {
        $barang_masuk_exist = Barang_masuk::findOrFail($barcode);

        if ($barang_masuk_exist) {
            $barang_masuk_exist->update([
                'jumlah' => $barang_masuk_exist->jumlah + $jml
            ]);
            return true;
        } else {
            return false;
        }
    }
}
