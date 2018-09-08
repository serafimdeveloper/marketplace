<?php

namespace App\Http\Requests\Accont\Clients;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        return [
            'name'=>'required',
            'cpf'=>'required|cpf_mascara|unique:users,cpf,'.$user->id,
            'birth'=>'required|date',
            'genre'=>'required',
            'phone'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'cpf.required' => 'O cpf é obrigatório',
            'cpf.cpf_mascara' => 'O cpf é inválido',
            'cpf.unique' => 'Esse cpf já está cadastrado no sistema',
            'birth.required' => 'A data de nascimento é obrigatório',
            'birth.date' => 'A data é inválida',
            'phone.required' => 'O telefone é obrigatório'
        ];
    }
}
