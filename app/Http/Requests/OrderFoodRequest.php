<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderFoodRequest extends FormRequest
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
            'name'      => 'required|min:3',
            'place_id'  => 'required|numeric',
            'date_delivery' => 'required|date_format:Y-m-d',
            'date_delivery_from' => 'required|date_format:"H:i:s"',


        ];
    }
}
