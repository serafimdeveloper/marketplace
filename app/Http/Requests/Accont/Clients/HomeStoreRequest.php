<?php

namespace App\Http\Requests\Accont\Clients;

use Illuminate\Foundation\Http\FormRequest;

class HomeStoreRequest extends FormRequest
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
