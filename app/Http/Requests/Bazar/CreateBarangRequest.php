<?php

namespace App\Http\Requests\Bazar;

use Illuminate\Foundation\Http\FormRequest;

class CreateBarangRequest extends FormRequest
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
        $rules = [];

        foreach ($this->request->get('barcode') as $key => $value) {
            $rules['barcode.' . $key] = 'bail|required|min:15|max:15';
            $rules['jumlah.' . $key] = 'bail|required|numeric';
        }

        return $rules;
    }

    public function message()
    {
        $messages = [];

        $messages['date'] = [
            'required' => 'Kolom tanggal harus diisi',
            'date'     => 'Kolom tanggal harus berupa tanggal',
        ];

        foreach ($this->request->get('barcode') as $key => $value) {
            $messages['barcode.' . $key . '.required'] = 'Kolom barcode ke-' . ($key + 1) . ' harus diisi';
            $messages['barcode.' . $key . '.max']      = 'Kolom barcode ke-' . ($key + 1) . ' harus 15 karakter';
            $messages['barcode.' . $key . '.min']      = 'Kolom barcode ke-' . ($key + 1) . ' harus 15 karakter';

            $messages['jumlah.' . $key . '.required'] = 'Kolom jumlah ke-' . ($key + 1) . ' harus diisi';
            $messages['jumlah.' . $key . '.numeric']  = 'Kolom jumlah ke-' . ($key + 1) . ' harus berupa angka';
        }

        return $messages;
    }
}
