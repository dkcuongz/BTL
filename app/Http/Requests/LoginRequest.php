<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'=>'required|min:5|email',
            'password'=>'required|min:5'
        ];
    }
    public function messages()
    {
        return [
            'email.required'=>'Email không được để trống',
            'email.min:5'=>'Email phải dài hơn 5 ký tự',
            'email.email'=>'Email phải là dạng email @gmail.com',
            'password.required'=>'Password không được để trống',
            'password.min:5'=>'Password phải dài hơn 5 ký tự'
        ];
    }
}
