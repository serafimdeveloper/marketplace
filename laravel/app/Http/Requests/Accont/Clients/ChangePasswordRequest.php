<?php

namespace App\Http\Requests\Accont\Clients;

use App\Http\Requests\Request;

class ChangePasswordRequest extends Request
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
            'password'=>'required|min:6',
            'newpassword'=>'required|min:6|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'A senha é obrigatório',
            'password.min' => 'A quantidade minima é de 6 caracteres',
            'newpassword.required' => 'A confirmação é obrigatório',
            'newpassword.min' => 'A quantidade mínima é de 6 caracteres',
            'newpassword.confirmed' => 'As senhas não conferem'
        ];
    }
}