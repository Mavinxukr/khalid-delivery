<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        $id = $this->request->get('user_id');
        return [
            'first_name' => 'required|max:30|unique:users,first_name',
            'last_name'  => 'required|max:30',
            'phone'      => 'required|max:13',
            'image'      => 'file',
            'password'   => 'min:6' ,
        ];
    }
}
