<?php

namespace App\Http\Requests\Supplier;

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
            'nama_supplier'   => 'bail|required|string|max:50',
            'alamat' => 'bail|required|string|max:120',
            'no_telp'   => 'bail|required|string|max:12',
        ];
    }

    public function messages()
    {
        return [
            'nama_supplier.required' => 'Kolom nama tidak boleh kosong',
            'nama_supplier.string'   => 'Kolom nama harus berupa teks',
            'nama_supplier.max'      => 'Maksimal 50 karakter',

            'alamat.required' => 'Kolom alamat tidak boleh kosong',
            'alamat.string'   => 'Kolom alamat harus berupa teks',
            'alamat.max'      => 'Maksimal 120 karakter',

            'no_telp.required' => 'Kolom nomor telepon tidak boleh kosong',
            'no_telp.string'   => 'Kolom nomor telepon harus berupa teks',
            'no_telp.max'      => 'Maksimal 12 karakter',
        ];
    }
}
