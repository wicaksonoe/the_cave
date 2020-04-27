<?php

namespace App\Http\Requests\Biaya\Bazar;

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
            'keterangan' => 'bail|required|max:100',
            'nominal'    => 'bail|required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'keterangan.required' => 'Kolom keterangan biaya tidak boleh kosong',
            'keterangan.max'      => 'Maksimal 100 karakter',

            'nominal.required' => 'Kolom nominal biaya tidak boleh kosong',
            'nominal.numeric'  => 'Gunakan angka saja',
        ];
    }
}
