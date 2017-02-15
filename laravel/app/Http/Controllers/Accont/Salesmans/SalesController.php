<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 31/01/2017
 * Time: 14:48
 */

namespace App\Http\Controllers\Accont\Salesmans;


use App\Http\Controllers\AbstractController;
use App\Model\Store;
use App\Repositories\Accont\RequestsRepository;
use App\Model\Category;
use App\Http\Requests\Accont\Salesman\ProductsStoreRequest;
use Auth;
use PDF;
use Correios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SalesController extends AbstractController
{
    protected $with = ['user','store','products','adress','freight','payment','requeststatus'];

    public function repo(){
        return RequestsRepository::class;
    }

    public function index(){
        $page = Input::get('page');
        if($store = Auth::user()->salesman->store){
            $requests = $this->repo->all($this->columns,$this->with,['store_id' => $store->id],[],10,$page);
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

    public function edit($id){
        $request = $this->repo->get($id,$this->columns,$this->with);
        $rastreamento = [];
        if(isset($request->tracking_code)){
          $rastreamento = Correios::rastrear($request->tracking_code);
        }
        if($request->visualized === 0){
            $request->fill(['visualized' =>1])->save();
        }
        return view('accont.sale_info', compact('request','rastreamento'));
    }

    public function tracking_code(Request $req, $id){
        $this->validate($req,[
            'tracking_code' => 'required'
        ]);
       if($request = $this->repo->update(['tracking_code'=>$req->tracking_code],$id)){
           flash('Código de rastreamento do correio salvo', 'accept');
           return redirect()->route('accont.salesman.sale_info');
       }
        flash('Erro ao salvar o código do correio', 'error');
        return redirect()->route('accont.salesman.sale_info');
    }

    public function update(){

    }

    public function tag($id){
        if($request = $this->repo->get($id,$this->columns,$this->with)){
            $store = Store::with(['adress'])->find($request->store->id);
            $pdf = PDF::loadView('layouts.parties.etiqueta',['request' => $request,'store'=> $store]);
            return $pdf->download($request->key.'.pdf');
        }

    }
}