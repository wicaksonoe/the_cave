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
            'username'              => 'bail|required|string|max:20',
            'password'              => 'bail|required|string|min:6|confirmed',
            'nama'                  => 'bail|required|string|max:50',
            'alamat'                => 'bail|required|string|max:120',
            'telp'                  => 'bail|required|max:12',
            'role'                  => 'bail|required|in:pegawai,admin',
        ];
    }
}
