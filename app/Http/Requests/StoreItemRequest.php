<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
            'item_code' =>'required|unique:items',
            'item_name' => 'required',
            'bal_kg' => 'required|numeric',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'item_code.unique'      => 'Kode Item sudah ada di system!',
            'item_code.required'    => 'Kode Item wajib diisi!',
            'item_name.required'    => 'Nama barang wajib diisi!',
            'bal_kg.required'       => 'bal/kg wajib diisi!',
            'bal_kg.numeric'        => 'Harap isi bal/kg dengan angka',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        /* $this->merge([
            'slug' => Str::slug($this->slug),
        ]); */
    }
}
