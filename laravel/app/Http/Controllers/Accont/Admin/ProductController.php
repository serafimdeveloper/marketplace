<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 12/04/2017
 * Time: 20:34
 */

namespace App\Http\Controllers\Accont\Admin;


use App\Repositories\Accont\ProductsRepository;
use App\Repositories\Accont\StoresRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends  AbstractAdminController
{

    public function __construct(ProductsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(StoresRepository $store, Request $request){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_accont');
        }
        $this->ordy = ['name' => 'ASC'];
        $this->with = ['store','galeries'];
        $this->where = ($request->store_id) ? ['store_id' => $request->store_id] : [];
        $this->title = 'Lista de Todos os Produtos';
        $this->placeholder = 'Pesquisar pelo nome do produto';
        $data = $this->search($request, 'products');
        $data['stores'] = $store->all()->pluck('name','id');
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }

    public function show($id){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_accont');
        }
        if($result = $this->getByRepoId($id)){
            return view('layouts.parties.alert_product_info', compact('result', 'stores'));
        }
        return response()->json(['msg' => 'Erro ao encontrar o produto'],404);
    }

    public function destroy($id){
        if($product = $this->repo->get($id)){
            $product->delete();
            return response()->json([],204);
        }
        return response()->json(['status'=> false],500);
    }

}