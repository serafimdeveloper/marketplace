<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Repositories\Accont\ProductsRepository;
use App\Repositories\Accont\CategoriesRepository;
use App\Repositories\Accont\ShopValuationsRepository;
use App\Repositories\Accont\StoresRepository;
use App\Repositories\FavoritesRepository;
use App\Repositories\VisitProductsRepository;
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

    public function index(FavoritesRepository $favorite){
        $features = $this->product->getHighlights($this->with_product);
        $news = $this->product->getNews($this->with_product)->shuffle()->all();
        $favorites = $favorite->getProductsFavorites();
        $categories_masters = $this->category->all($this->columns, $this->with_category);
        return view('pages.homepage', compact('features','news','categories_masters','favorites'));
    }

    public function single_page(ShopValuationsRepository $shopvaluations, VisitProductsRepository $visit_products , $store, $category, $prod){
        if($product = $this->product->single_page($this->with_product, $store, $category, $prod)){
            $type = ['type' => 'product', 'id' => $product->id];
            $visit_products->add_visit_product($product);
            $notes = $shopvaluations->getNotes($product);
            $count = $this->product->countRequests($product);
            return view('pages.product', compact('product','type','notes', 'count'));
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
