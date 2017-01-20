<?php
	namespace App\Http\Requests\Accont;
	use Illuminate\Foundation\Http\FormRequest;

	class AdressesStoreRequest extends FormRequest
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
	            'zip_code'=>'required|string|max:9',
	            'state'=>'required|string|min:2|max:2',
	            'city'=>'required|min:3|max:30',
	            'public_place'=>'required|min:3|max:50',
	            'neighborhood'=>'required|string|max:30',
	            'number'=>'required|numeric',
	            'complements'=>'string|max:30'
	        ];
	    }
    }
