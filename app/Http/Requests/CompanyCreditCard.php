<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreditCard extends FormRequest
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
            'holder_name' => 'required',
            'number_card' => 'required',
            'expire_month' => 'required|numeric',
            'expire_year' => 'required|numeric',
            'cvv_code' => 'required||numeric',
            'zip_code' => 'required|numeric',
        ];
    }
}
