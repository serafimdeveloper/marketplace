<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class PageRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return Gate::allows('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            'title' => 'required|string|min:3',
            'content' => 'required|string|min:10'
        ];
    }
    public function messages(){
        return ['title' => 'Título: Mínimo 3 caracteres', 'content' => 'Conteúdo: Mínimo de 10 cararcteres',];
    }
}
