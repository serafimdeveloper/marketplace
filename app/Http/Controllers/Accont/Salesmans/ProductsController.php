<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 31/01/2017
 * Time: 14:48
 */

namespace App\Http\Controllers\Accont\Salesmans;


use App\Http\Controllers\AbstractController;
use App\Repositories\Accont\ProductsRepository;
use App\Model\Category;
use App\Http\Requests\Accont\Salesman\ProductsStoreRequest;
use Auth;

class ProductsController extends AbstractController
{
    protected $with = ['category','subcategory'];
    public function repo(){
        return ProductsRepository::class;
    }

    public function index(){
        $store = Auth::user()->salesman->store;
        $products = $this->repo->all($this->columns,$this->with,['store_id' => $store->id]);
        return view('accont.products', compact('products'));
    }

    public function create(Category $category){
        $categories = $category->pluck('name','id');
        return view('accont.product_info', compact('categories'));
    }

    public function store(ProductsStoreRequest $request){
        $store  = Auth::user()->salesman->store;
        $dados = $request->except(['image_master', 'image']);
        $dados['store_id'] = $store->id;



    }

    public function edit(Category $category, $id){
        $categories = $category->pluck('name', 'id');
        $product = $this->repo->get($id, $this->columns, $this->with);
        return view('accont.product_info', compact('categories', 'product'));
    }

    public function update(){

    }


    private function salve_imgs(){

    }
}