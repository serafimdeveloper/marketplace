<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Repositories\Accont\ProductsRepository;
use App\Repositories\Accont\CategoriesRepository;
use App\Repositories\Accont\StoresRepository;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    protected $category, $store, $product;
    protected $with_product = ['galeries','store','category'],$with_category = [], $with_store = ['products','adress'] ;
    protected $columns = ['*'];

    public function __construct(ProductsRepository $product, CategoriesRepository $category, StoresRepository $store){
        $this->product = $product;
        $this->category = $category;
        $this->store = $store;
    }

    public function index(){
        $features = $this->product->getHighlights($this->with_product);
        $news = $this->product->all($this->columns, $this->with_product,[],['created_at'=>'DESC'],20,1);
        $categories_masters = $this->category->all($this->columns, $this->with_category);
        return view('pages.homepage', compact('features','news','categories_masters'));
    }

    public function single_page($store, $category, $prod){
        if($user = Auth::user()){
            $auth = $user->id;
        }
        $product = $this->product->single_page($this->with_product, $store, $category, $prod);
        $type = ['type' => 'product', 'id' => $product->id];
        return view('pages.product', compact('product','type', 'auth'));
    }

    public function category($category){

        return view('pages.products');
    }

    public function search($search){
        return view('pages.products');
    }

    public function favorites(){
        return view('pages.favorites');
    }

    public function stores($slug){
        if($store = $this->store->getStoreSlug($this->with_store, $slug)){
            if(!(!$store->active || $store->blocked)){
                return view('pages.store', compact('store'));
            }

        }


    }

}
