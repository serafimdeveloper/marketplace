<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Model\User;
use App\Repositories\Account\ProductsRepository;
use App\Repositories\Account\CategoriesRepository;
use App\Repositories\Account\ShopValuationsRepository;
use App\Repositories\Account\StoresRepository;
use App\Repositories\FavoritesRepository;
use App\Repositories\VisitProductsRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller {

    protected $category, $store, $product, $favorite;
    protected $with_product = ['galleries','store','category'],$with_category = [], $with_store = ['products','address'] ;
    protected $columns = ['*'];

    public function __construct(ProductsRepository $product, CategoriesRepository $category, StoresRepository $store, FavoritesRepository $favorite){
        $this->product = $product;
        $this->category = $category;
        $this->store = $store;
        $this->favorite = $favorite;
//        Auth::login(User::find(28));
    }

    public function index(){
        $features = $this->product->getHighlights($this->with_product);
        $news = $this->product->getNews($this->with_product)->shuffle()->all();
        $favorites = $this->favorite->getProductsFavorites();
        $categories_masters = $this->category->all($this->columns, $this->with_category);
        return view('pages.homepage', compact('features','news','categories_masters','favorites'));
    }

    public function single_page(ShopValuationsRepository $shopvaluations, VisitProductsRepository $visit_products , $store, $category, $prod){
        if($product = $this->product->single_page($this->with_product, $store, $category, $prod)){
            $type = ['type' => 'product', 'id' => $product->id];
            $visit_products->add_visit_product($product);
            $notes = $shopvaluations->getNotes($product);
            $count = $this->product->countRequests($product);
            $store = $product->store;
            if($product->active && $store->active && $store->seller->active){
                return view('pages.product', compact('product','type','notes', 'count'));
            }else{
                if(Auth::check()){
                    if(Gate::allows('store_access',$store)){
                        $blocked = true;
                        return view('pages.product', compact('product','type','notes', 'count', 'blocked'));
                    }
                }
            }
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
            $favorites = $this->favorite->getProductsFavorites();
            if($store->active && $store->seller->active){
                return view('pages.store', compact('store','favorites'));
            }else{
                if(Auth::check()){
                    if(Gate::allows('store_access',$store)){
                        $blocked = true;
                        return view('pages.store', compact('store','favorites','blocked'));
                    }
                }
            }
        }
        return view('errors.404');
    }

}
