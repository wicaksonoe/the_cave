<?php

namespace App\Http\Requests\Bazar;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangRequest extends FormRequest
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
            'jumlah' => 'bail|required|numeric'
        ];
    }

    public function message()
    {
        return [
            'jumlah' => [
                'required' => 'Kolom jumlah harus diisi',
                'integer'  => 'Kolom jumlah harus berupa angka',
            ],
        ];
    }
}
