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
	            'public_place'=>'required|min:3|max:50',
	            'neighborhood'=>'required|string|max:30',
	            'number'=>'required|numeric',
	            'complements'=>'string|max:30'
	        ];
	    }
    }
