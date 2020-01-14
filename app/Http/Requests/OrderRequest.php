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
            'count_clean'   => 'max:20',
            'name' => 'required|max:100',
            'product_id' => 'required',
            'place_id' => 'required',
            'date_delivery' => 'required',
            'date_delivery_from' => 'required',
            'date_delivery_to' => 'required',
            'quantity'  => 'required'

        ];
    }
}
