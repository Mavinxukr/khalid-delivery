<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
            'count_clean'   => 'max:20|numeric',
            'name' => 'required|max:100',
            'product_id' => 'required|numeric',
            'place_id' => 'required|numeric',
            'date_delivery' => 'required|date_format:Y-m-d',
            'date_delivery_from' => 'required|date_format:"H:i:s"',
            'date_delivery_to' => 'required|date_format:"H:i:s"',
        ];
    }
}
