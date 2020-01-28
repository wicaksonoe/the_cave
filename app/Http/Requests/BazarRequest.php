<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BazarRequest extends FormRequest
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
						'nama_bazar' => 'required|string',
						'alamat'     => 'required|string',
						'tgl'        => 'required|date',
						'potongan'   => 'required|numeric',
        ];
    }
}
