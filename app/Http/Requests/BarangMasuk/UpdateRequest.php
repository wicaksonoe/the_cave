<?php

namespace App\Http\Requests\BarangMasuk;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getUser()->role == 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'barcode'  => 'bail|required|string|max:15|min:15',
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

    public function message()
    {
        $harus = ' harus diisi';
        $numeric = ' harus berupa angka';
        return [
            'barcode'  => [
                'required' => 'Kolom barcode ' . $harus,
                'string'   => 'Kolom barcode harus berupa teks',
                'max'      => 'Kolom barcode harus 15 karakter',
                'min'      => 'Kolom barcode harus 15 karakter',
            ],
            'namabrg'  => [
                'required' => 'Kolom nama barang ' . $harus,
                'string'   => 'Kolom nama barang harus berupa teks',
                'max'      => 'Kolom nama barang maksimal 50 karakter',
            ],
            'id_jenis' => [
                'required' => 'Kolom jenis barang ' . $harus,
                'numeric'  => 'Kolom jenis barang ' . $numeric,
            ],
            'id_tipe'  => [
                'required' => 'Kolom tipe barang ' . $harus,
                'numeric'  => 'Kolom tipe barang ' . $numeric,
            ],
            'id_sup'   => [
                'required' => 'Kolom supplier ' . $harus,
                'numeric'  => 'Kolom supplier ' . $numeric,
            ],
            'jumlah'   => [
                'required' => 'Kolom jumlah ' . $harus,
                'numeric'  => 'Kolom jumlah ' . $numeric,
            ],
            'hpp'      => [
                'required' => 'Kolom harga pokok penjualan ' . $harus,
                'numeric'  => 'Kolom harga pokok penjualan ' . $numeric,
            ],
            'hjual'    => [
                'required' => 'Kolom harga jual ' . $harus,
                'numeric'  => 'Kolom harga jual ' . $numeric,
            ],
            'grosir'   => [
                'required' => 'Kolom harga grosir ' . $harus,
                'numeric'  => 'Kolom harga grosir ' . $numeric,
            ],
            'partai'   => [
                'required' => 'Kolom harga partai ' . $harus,
                'numeric'  => 'Kolom harga partai ' . $numeric,
            ],
        ];
    }
}
