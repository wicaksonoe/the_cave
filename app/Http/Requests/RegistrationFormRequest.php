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
					'username'              => 'required|string|unique:users,username',
					'password'              => 'required|string|min:6|confirmed',
					'nama'                  => 'required|string',
					'alamat'                => 'required|string',
					'telp'                  => 'required',
					'role'                  => 'required|in:pegawai,admin',
        ];
    }
}