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
            'genre'=>'required'
        ];
    }
}
