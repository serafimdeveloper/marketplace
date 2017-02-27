<?php

namespace App\Http\Requests\Accont\Salesman;
use App\Http\Requests\Request;

class SalesmanUpdateRequest extends Request
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
            'cpf_mascara' => 'O :attribute é inválido',
        ];
    }

}