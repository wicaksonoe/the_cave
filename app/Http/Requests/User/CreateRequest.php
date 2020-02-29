<?php

namespace App\Http\Requests\User;

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
            'username' => 'bail|required|string|unique:users,username|max:20',
            'password' => 'bail|required|string|min:6|confirmed',
            'nama'     => 'bail|required|string|max:50',
            'alamat'   => 'bail|required|string|max:120',
            'telp'     => 'bail|required|max:12',
            'role'     => 'bail|required|in:pegawai,admin',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Kolom username tidak boleh kosong',
            'username.string'   => 'Kolom username harus berupa teks',
            'username.unique'   => 'Username sudah digunakan',
            'username.max'      => 'Username maksimal 20 karakter',

            'password.required'  => 'Kolom password tidak boleh kosong',
            'password.string'    => 'Kolom password harus berupa teks',
            'password.min'       => 'Password minimal 6 karakter',
            'password.confirmed' => 'Password tidak sama dengan konfirmasi',

            'nama.required' => 'Kolom nama tidak boleh kosong',
            'nama.string'   => 'Kolom nama harus berupa teks',
            'nama.max'      => 'Nama maksimal 50 karakter',

            'alamat.required' => 'Kolom alamat tidak boleh kosong',
            'alamat.string'   => 'Kolom alamat harus berupa teks',
            'alamat.max'      => 'bail|required|string|max:120',

            'telp.required' => 'Kolom nomor telepon tidak boleh kosong',
            'telp.max'      => 'Nomor telepon maksimal 12 karakter',

            'role.required' => 'Kolom role tidak boleh kosong',
            'role.in'       => 'Pilihan hanya pegawai/admin',
        ];
    }
}
