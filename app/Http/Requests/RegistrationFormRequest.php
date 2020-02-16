<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationFormRequest extends FormRequest
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
            'username'              => 'required|string|max:20',
            'password'              => 'required|string|min:6|confirmed',
            'nama'                  => 'required|string|max:50',
            'alamat'                => 'required|string|max:120',
            'telp'                  => 'required|max:12',
            'role'                  => 'required|in:pegawai,admin',
        ];
    }
}
