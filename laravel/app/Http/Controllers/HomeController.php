<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Repositories\Accont\ProductsRepository;
use App\Repositories\Accont\CategoriesRepository;
use App\Repositories\Accont\StoresRepository;
use App\Repositories\FavoritesRepository;
use App\Repositories\VisitProductsRepository;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    protected $category, $store, $product, $favorite, $visit_products;
    protected $with_product = ['galeries','store','category'],$with_category = [], $with_store = ['products','adress'] ;
    protected $columns = ['*'];

    public function __construct(ProductsRepository $product, CategoriesRepository $category,VisitProductsRepository $visit_products, StoresRepository $store, FavoritesRepository $favorite){
        $this->product = $product;
        $this->category = $category;
        $this->store = $store;
        $this->favorite = $favorite;
        $this->visit_products = $visit_products;
    }

    public function index(){
        $features = $this->product->getHighlights($this->with_product);
        $news = $this->product->getNews($this->with_product)->shuffle()->all();
        $favorites = $this->favorite->getProductsFavorites();
        $categories_masters = $this->category->all($this->columns, $this->with_category);
        return view('pages.homepage', compact('features','news','categories_masters','favorites'));
    }

    public function single_page($store, $category, $prod){
        if($product = $this->product->single_page($this->with_product, $store, $category, $prod)){
            $type = ['type' => 'product', 'id' => $product->id];
            $this->visit_products->add_visit_product($product);
            return view('pages.product', compact('product','type'));
        }
        return view('errors.404');
    }

    public function category($search){
        $products = $this->product->productsCategory($this->with_product, $search);
        $favorites = $this->favorite->getProductsFavorites();
        return view('pages.products', compact('products','search','favorites'));
    }

    public function search($search){
        $products = $this->product->searchProducts($this->with_product, $search);
        $favorites = $this->favorite->getProductsFavorites();
        return view('pages.products', compact('products','search','favorites'));
    }

    public function stores($slug){
        if($store = $this->store->getStoreSlug($this->with_store, $slug)){
            if(!(!$store->active || $store->blocked)){
                $favorites = $this->favorite->getProductsFavorites();
                return view('pages.store', compact('store','favorites'));
            }
        }


    }

}
