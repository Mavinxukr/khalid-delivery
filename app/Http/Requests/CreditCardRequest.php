<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditCardRequest extends FormRequest
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
            'holder_name' => 'required|max:50',
            'number_card' => 'required|max:20',
            'expire_month' => 'required|max:2',
            'expire_year' => 'required|max:2',
            'cvv_code' => 'required|max:3',
            'zip_code' => 'required|max:5',
        ];
    }
}
