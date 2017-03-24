<?php

namespace App\Http\Requests\Accont\Salesman;
use App\Http\Requests\Request;

class SalesmanStoreRequest extends Request
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
            'photo_document'=>'required|image|mimes:png,jpg,jpeg|max:10000',
            'proof_adress'=>'required|file|mimes:png,jpg,jpeg,pdf|max:10000',
            'moip'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'O telefone é obrigatório',
            'cellphone.required' => 'O celular é obrigatório',
            'photo_document.required' => 'A foto do documento é obrigatório',
            'photo_document.image' => 'A foto do documento tem que ser do tipo imagem',
            'photo_document.mimes' => 'O tipo de imagem é inválido',
            'photo_document.max' => 'O tamanho máximo da foto do documento é de 10Mb',
            'proof_adress.required' => 'O comprovante de endereço é obrigatório',
            'proof_adress.file' => 'O comprovante de endereço é do tipo inválido',
            'proof_adress.mimes' => 'O tipo de arquivo é inválido',
            'proof_adress.max' => 'O tamanho máximo da foto do compravante de endereço é de 10Mb',
            'moip.required' => 'O login do moip é obrigatório'
        ];
    }

}