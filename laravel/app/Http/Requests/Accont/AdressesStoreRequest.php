<?php
	namespace App\Http\Requests\Accont;
    use App\Http\Requests\Request;

	class AdressesStoreRequest extends Request
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
	            'zip_code'=>'required|regex:/^\d{5}-?\d{3}$/',
	            'state'=>'required|string|min:2|max:2',
	            'city'=>'required|min:3|max:100',
	            'public_place'=>'required|min:3|max:100',
	            'neighborhood'=>'required|string|max:50',
	            'number'=>'required',
	            'complements'=>'string|max:30'
	        ];
	    }

	    public function messages()
        {
            return [
                'zip_code.required' => 'O cep é obrigatório',
                'zip_code.regex' => 'O formato do cep é inválido',
                'state.required' => 'O estado é obrigatório',
                'state.string' => 'O estado é do tipo texto',
                'state.min' => 'O estado deve conter 2 caracteres',
                'state.max' => 'O estado deve conter 2 caracteres',
                'city.required' => 'A cidade é obrigatório',
                'city.min' => 'O mínimo é de 3 caracteres',
                'city.max' => 'O máximo é de 100 caracteres',
                'public_place.required' => 'A rua é obrigatório',
                'public_place.min' => 'O mínimo é de 3 caracteres',
                'public_place.max' => 'O máximo é de 100 caracteres',
                'neighborhood.required' => 'o bairro é obrigatório',
                'neighborhood.string' => 'O bairro é do tipo string',
                'neighborhood.max' => 'O máximo é de 50 caracteres',
                'number.required' => 'O número é obrigatório',
                'number.numeric' => 'O número e do tipo númerico',
                'complements.string' => 'O complemento é do tipo string',
                'complements.max' => 'O máximo é de 30 caracteres'
            ];
        }
    }
