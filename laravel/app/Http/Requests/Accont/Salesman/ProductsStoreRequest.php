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
            'deadline' => 'required|numeric|max:15',
            'minimum_stock'=>'required|numeric',
            'details'=>'required|string|max:500',
            'image_0' => 'required',
            'image.*' => 'mimes:png,jpg,jpeg,pdf|max:10000',
            'length_cm' => 'required|numeric|min:16|max:105',
            'width_cm' => 'required|numeric|min:11|max:105',
            'height_cm' => 'required|numeric|min:2|max:105',
            'weight_gr' => 'required|numeric|min:300|max:30000',
        ];
    }

    public function messages() {
        return [
            'name.required' => 'O nome do produto é obrigatório',
            'name.unique' => 'Já contém um produto com esse nome',
            'name.max' => 'A quantidade máxima de caracteres é 50',
            'name.min' => 'A quantidade mínima de caracteres é 3',
            'category_id.required' => 'A categória é obrigatório',
            'category_id.numeric' => 'A categória dever ser um número',
            'price.required' => 'O preço é obrigatório',
            'price.numeric' => 'O preço deve ser um número',
            'deadline.required' => 'O prazo é obrigatório',
            'deadline.numeric' => 'O prazo deve ser um número',
            'minimum_stock.required' => 'O número de estoque mínimo obrigatório',
            'minimum_stock.numeric' => 'O estoque mínimo deve ser um número',
            'details.required' => 'O detalhe do produto é obrigatório',
            'details.string' => 'O detalhe do produto deve ser um texto',
            'details.max' => 'A quantidade máxima de caracteres é de 500',
            'image_0.required' => 'A imagem é obrigatório',
            'image.*.mimes' => 'O tipo de imagem é inválido (PNG, JPG, JPEG, PDF)',
            'image.*.max' => 'O tamanho de imagem excedido',
            'length_cm.required' => 'O comprimento é obrigatório',
            'length_cm.numeric' => 'O comprimento deve ser um número',
            'length_cm.min' => 'O valor mínimo é de 16cm',
            'length_cm.max' => 'O valor máximo é de 105cm',
            'width_cm.required' => 'A largura é obrigatório',
            'width_cm.numeric' => 'A largura deve ser um número',
            'width_cm.min' => 'O valor mínimo é de 10cm',
            'width_cm.max' => 'O valor máximo é de 105cm',
            'height_cm.required' => 'A altura é obrigatório',
            'height_cm.numeric' => 'A altura deve ser um número',
            'height_cm.min' => 'O valor mínimo é de 2cm',
            'height_cm.max' => 'O valor máximo é de 105cm',
            'weight_gr.required' => 'A peso é obrigatório',
            'weight_gr.numeric' => 'A peso deve ser um número',
            'weight_gr.min' => 'O valor mínimo é de 300 gramas',
            'weight_gr.max' => 'O valor máximo é de 30000 gramas'
        ];
    }
}