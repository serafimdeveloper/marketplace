<?php

namespace App\Http\Requests\Account\Seller;
use App\Http\Requests\Request;

class StoresStoreRequest extends Request
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
            'cpf'=>'required|cpf_mascara|unique',
            'phone'=>'required',
            'cellphone'=>'required',
            'whatsapp'=> 'required',
            'photo_document'=>'required|image|mimes:png,jpg,jpeg|max:10000',
            'proof_address'=>'required|file|mimes:png,jpg,jpeg,pdf|max:10000',
            'moip'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'cpf_mascara' => 'O :attribute é inválido',
        ];
    }

}