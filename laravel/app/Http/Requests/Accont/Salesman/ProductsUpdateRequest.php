<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 31/01/2017
 * Time: 16:27
 */

namespace App\Http\Requests\Accont\Salesman;
use App\Model\Product;
Use Auth;
use Illuminate\Validation\Rule;
use App\Http\Requests\Request;

class ProductsUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id = $this->route('product');
        return Product::where('id',$id)->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $store = Auth::user()->salesman->store;
        $id = $this->route('product');
        return [
            'name' => ['required',
                Rule::unique('products')->where(function($query) use($store){
                    $query->where('store_id',$store->id);
                 })->ignore($id),'max:50','min:3'
            ],
            'category_id' => 'required|numeric',
            'price' => 'required|numeric',
            'price_out_discount' => 'numeric',
            'deadline' => 'required|numeric',
            'minimum_stock'=>'required|numeric',
            'details'=>'required|string|max:500',
            'image.*' => 'mimes:png,jpg,jpeg,pdf|max:10000',
            'length_cm' => 'required|numeric',
            'width_cm' => 'required|numeric',
            'height_cm' => 'required|numeric',
            'weight_gr' => 'required|numeric',
            'diameter_cm' => 'required|numeric',
        ];
    }
}