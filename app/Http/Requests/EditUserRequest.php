<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            'email'=>'required|email|unique:users,email,'.$this->idUser,
            'password'=>'required|min:5',
            'full'=>'required|min:5',
            'phone'=>'required',
            'address'=>'required|min:8',
        ];
    }
    public function messages()
    {
        return [
            'email.required'=>'Không được để trống email',
            'email.unique'=>'Email đã tồn tại',
            'password.required'=>'Không được để trống password',
            'password.min'=>'Password không được nhỏ hơn 5 ký tự',
            'email.email'=>'Email không đúng định dạng',
            'full.required'=>'Không được để trống Họ và tên',
            'full.min'=>'Họ tên không được nhỏ hơn 5 ký tự',
            'phone.required'=>'số điện thoại không được để trống',
            'address.required'=>'địa chỉ không được để trống',
            'address.min'=>'Địa chỉ không được nhỏ hơn 8 ký tự',
            
        ];
    }
}