<?php

namespace App\Http\Requests\Account\Seller;
use App\Http\Requests\Request;

class SellerUpdateRequest extends Request
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
            'phone'=>'required',
            'cellphone'=>'required',
            'moip'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'O telefone é obrigatório',
            'cellphone.required' => 'O celular é obrigatório',
            'moip.required' => 'O login do moip é obrigatório'
        ];
    }

}