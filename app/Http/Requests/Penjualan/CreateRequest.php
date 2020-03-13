<?php

namespace App\Http\Requests\Penjualan;

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
        $rules = [];

        foreach ($this->request->get('barcode') as $key => $value) {
            $rules['barcode.' . $key]      = 'bail|required|min:15|max:15';
            $rules['jumlah.' . $key]       = 'bail|required|numeric';
            $rules['harga_partai.' . $key] = 'bail|required|in:0,1';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [];

        foreach ($this->request->get('barcode') as $key => $value) {
            $messages['barcode.' . $key . '.required'] = 'The barcode number ' . ($key + 1) . ' field is required';
            $messages['barcode.' . $key . '.max']      = 'The barcode number ' . ($key + 1) . ' must be 15 character';
            $messages['barcode.' . $key . '.min']      = 'The barcode number ' . ($key + 1) . ' must be 15 character';

            $messages['jumlah.' . $key . '.required'] = 'The jumlah number ' . ($key + 1) . ' field is required';
            $messages['jumlah.' . $key . '.numeric']  = 'The jumlah number ' . ($key + 1) . ' must be numeric';

            $messages['harga_partai.' . $key . '.required'] = 'The jumlah number ' . ($key + 1) . ' field is required';
            $messages['harga_partai.' . $key . '.in']       = 'The jumlah number ' . ($key + 1) . ' must be "ya" or "tidak"';
        }

        return $messages;
    }
}
