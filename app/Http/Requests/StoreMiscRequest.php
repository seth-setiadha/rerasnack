<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMiscRequest extends FormRequest
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
            'tanggal' => 'required|date',
            'misc_name' => 'required',
            'qty' => 'required|numeric',
            'unit_price' => 'required|numeric',
            'sub_total' => 'numeric',
        ];
    }
}
