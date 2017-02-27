<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Repositories\Accont\ProductsRepository;
use App\Repositories\Accont\CategoriesRepository;
class HomeController extends Controller {

    protected $product;
    protected $with_product = ['galeries','store','category'];
    protected $category;
    protected $with_category = [];
    protected $columns = ['*'];

    public function __construct(ProductsRepository $product, CategoriesRepository $category){
        $this->product = $product;
        $this->category = $category;
    }

    public function index(){
        $features = $this->product->all($this->columns, $this->with_product,[],[],20,1);
        $news = $this->product->all($this->columns, $this->with_product,[],['created_at'=>'DESC'],20,1);
        $categories_masters = $this->category->all($this->columns, $this->with_category);
        return view('pages.homepage', compact('features','news','categories_masters'));
    }

    public function single_page($store, $category, $prod){
        $product = $this->product->single_page($this->with_product, $store, $category, $prod);
        $type = ['type' => 'product', 'id' => $product->id];
        return view('pages.product', compact('product','type'));
    }

}
