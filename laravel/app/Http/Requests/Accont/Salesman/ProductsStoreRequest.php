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
use App\Http\Requests\Request;

class ProductsStoreRequest extends Request
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
            'price_out_discount' => 'numeric',
            'deadline' => 'required|numeric',
            'minimum_stock'=>'required|numeric',
            'details'=>'required|string|max:500',
            'image_1' => 'required',
            'image.*' => 'mimes:png,jpg,jpeg,pdf|max:10000',
            'length_cm' => 'required|numeric|min:16|max:105',
            'width_cm' => 'required|numeric|min:11|max:105',
            'height_cm' => 'required|numeric|min:2|max:105',
            'weight_gr' => 'required|numeric|min:1|max:30000',
            'diameter_cm' => 'required|numeric|min:5|max:91',
        ];
    }
}