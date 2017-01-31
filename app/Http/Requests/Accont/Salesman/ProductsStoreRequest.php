<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 31/01/2017
 * Time: 16:27
 */

namespace App\Http\Requests\Accont\Salesman;
Use Auth;
use Illuminate\Validation\Rule;

class ProductsStoreRequest extends FormRequest
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
        $store = Auth::user()->salesman->store;
        return [
            'name' => ['required',
                Rule::unique('products')->where(function($query) use($store){
                    $query->where('store_id',$store->id);
                 }),'max:50','min:3'
            ],
            'category_id' => 'required|numeric',
            'price' => 'required|numeric',
            'price_with_desconto' => 'numeric',
            'deadline' => 'required|numeric',
            'free_shipping'=>'boolean',
            'details'=>'required|string|max:500',
            'image_master' => 'required|image|mimes:png,jpg,jpeg|max:10000',
            'image' => 'file|mimes:png,jpg,jpeg,pdf|max:10000',
            'length_cm' => 'required|numeric',
            'width_cm' => 'required|numeric',
            'height_cm' => 'required|numeric',
            'weight_gr' => 'required|numeric',
            'diameter_cm' => 'required|numeric',
            'active'=>'boolean'
        ];
    }

    public function messages()
    {
        return [
            'cpf_mascara' => 'O :attribute é inválido',
        ];
    }

}