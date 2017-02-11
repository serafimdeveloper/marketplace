<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 31/01/2017
 * Time: 14:48
 */

namespace App\Http\Controllers\Accont\Salesmans;


use App\Http\Controllers\AbstractController;
use App\Repositories\Accont\RequestsRepository;
use App\Model\Category;
use App\Http\Requests\Accont\Salesman\ProductsStoreRequest;
use Auth;

class SalesController extends AbstractController
{
    protected $with = ['user','store'];

    public function repo(){
        return RequestsRepository::class;
    }

    public function index(){
        if($store = Auth::user()->salesman->store){
            $requests = $this->repo->all($this->columns,$this->with,['store_id' => $store->id],[],15);
            return view('accont.sales', compact('requests'));
        }
        flash('Você ainda não possui uma Loja!', 'warning');
        return redirect()->route('accont.salesman.stores');

    }

    public function create(Category $category){
        $categories = $category->pluck('name','id');
        return view('accont.product_info', compact('categories'));
    }

    public function store(ProductsStoreRequest $request){
        $store  = Auth::user()->salesman->store;
        $dados = $request->except(['image_master', 'image']);
        $dados['store_id'] = $store->id;
        if($product = $this->repo->store($dados)){

        }



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