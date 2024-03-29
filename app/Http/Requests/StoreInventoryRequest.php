<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryRequest extends FormRequest
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
            "item_id" => 'numeric',
            "stock_id" => 'numeric',
            "tanggal" => 'date',
            "qty" => 'numeric',
            "unit" => '',
            "unit_price" => 'numeric',
            "temp_id" => '',
        ];
    }
}
