<?php

namespace App\Http\Requests\Bazar;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_bazar' => 'bail|required|string|max:50',
            'alamat'     => 'bail|required|string|max:120',
            'tgl_mulai'  => 'bail|required|date',
            'tgl_akhir'  => 'bail|required|date',
            'potongan'   => 'bail|required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'nama_bazar' => [
                'required' => 'Kolom nama bazar harus diisi',
                'string'   => 'Kolom nama bazar harus berupa teks',
                'max'      => 'Nama bazar maksimal 50 karakter',
            ],
            'alamat' => [
                'required' => 'Kolom alamat harus diisi',
                'string'   => 'Kolom alamat harus berupa teks',
                'max'      => 'Alamat maksimal 120 karakter',
            ],
            'tgl_mulai' => [
                'required' => 'Kolom tanggal mulai bazar harus diisi',
                'date'     => 'Kolom tanggal mulai bazar harus berupa tanggal',
            ],
            'tgl_akhir' => [
                'required' => 'Kolom tanggal akhir bazar harus diisi',
                'date'     => 'Kolom tanggal akhir bazar harus berupa tanggal',
            ],
            'potongan' => [
                'required' => 'Kolom potongan harga harus diisi',
                'numeric'  => 'Kolom potongan harga harus berupa angka',
            ],
        ];
    }
}
