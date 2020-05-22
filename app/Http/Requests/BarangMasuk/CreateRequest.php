<?php

namespace App\Http\Requests\BarangMasuk;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard()->user()->role == 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'barcode'  => 'bail|required|string|unique:barang_masuks,barcode|max:15|min:15',
            'namabrg'  => 'bail|required|string|max:50',
            'id_jenis' => 'bail|required|numeric',
            'id_tipe'  => 'bail|required|numeric',
            'id_sup'   => 'bail|required|numeric',
            'jumlah'   => 'bail|required|numeric',
            'hpp'      => 'bail|required|numeric',
            'hjual'    => 'bail|required|numeric',
            'grosir'   => 'bail|required|numeric',
            'partai'   => 'bail|required|numeric',
        ];
    }

    public function messages()
    {
        $harus = ' harus diisi';
        $numeric = ' harus berupa angka';
        return [
            'barcode.required' => 'Kolom barcode ' . $harus,
            'barcode.string'   => 'Kolom barcode harus berupa teks',
            'barcode.unique'   => 'Barcode sudah terdaftar',
            'barcode.max'      => 'Kolom barcode harus 15 karakter',
            'barcode.min'      => 'Kolom barcode harus 15 karakter',

            'namabrg.required' => 'Kolom nama barang ' . $harus,
            'namabrg.string'   => 'Kolom nama barang harus berupa teks',
            'namabrg.max'      => 'Kolom nama barang maksimal 50 karakter',

            'id_jenis.required' => 'Kolom jenis barang ' . $harus,
            'id_jenis.numeric'  => 'Kolom jenis barang ' . $numeric,

            'id_tipe.required' => 'Kolom tipe barang ' . $harus,
            'id_tipe.numeric'  => 'Kolom tipe barang ' . $numeric,

            'id_sup.required' => 'Kolom supplier ' . $harus,
            'id_sup.numeric'  => 'Kolom supplier ' . $numeric,

            'jumlah.required' => 'Kolom jumlah ' . $harus,
            'jumlah.numeric'  => 'Kolom jumlah ' . $numeric,

            'hpp.required' => 'Kolom harga pokok penjualan ' . $harus,
            'hpp.numeric'  => 'Kolom harga pokok penjualan ' . $numeric,

            'hjual.required' => 'Kolom harga jual ' . $harus,
            'hjual.numeric'  => 'Kolom harga jual ' . $numeric,

            'grosir.required' => 'Kolom harga grosir ' . $harus,
            'grosir.numeric'  => 'Kolom harga grosir ' . $numeric,

            'partai.required' => 'Kolom harga partai ' . $harus,
            'partai.numeric'  => 'Kolom harga partai ' . $numeric,
        ];
    }
}
