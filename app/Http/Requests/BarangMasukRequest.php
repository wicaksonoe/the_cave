<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangMasukRequest extends FormRequest
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
			'barcode'  => 'required',
			'namabrg'  => 'required|string',
			'id_jenis' => 'required|numeric',
			'id_tipe'  => 'required|numeric',
			'id_sup'   => 'required|numeric',
			'jumlah'   => 'required|numeric',
			'hpp'      => 'required|numeric',
			'hjual'    => 'required|numeric',
			'grosir'   => 'required|numeric',
			'partai'   => 'required|numeric',
			'tgl'      => 'required|date',
		];
	}
}
