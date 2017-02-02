<?php

namespace App\Http\Requests\Accont\Clients;

use App\Http\Requests\Request;

class HomeStoreRequest extends Request
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
            'name'=>'required',
            'cpf'=>'cpf_mascara',
            'birth'=>'required|date',
            'genre'=>'required'
        ];
    }
}
