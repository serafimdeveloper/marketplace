<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 31/01/2017
 * Time: 14:48
 */

namespace App\Http\Controllers\Accont\Salesmans;


use App\Http\Controllers\AbstractController;
use App\Model\RequestStatus;
use App\Model\Store;
use App\Repositories\Accont\RequestsRepository;
use App\Model\Category;
use App\Http\Requests\Accont\Salesman\ProductsStoreRequest;
use Auth;
use Illuminate\Support\Facades\Gate;
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
        $req = Request::capture();
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        $request_status = RequestStatus::pluck('description', 'id');
        $selected_status = (isset($req->all()['status']) ? (int) $req->all()['status'] : null);
        $page = Input::get('page');
        if($store = Auth::user()->salesman->store){
            $this->status_request();
            $where = ($selected_status ? [['store_id', '=', $store->id], ['request_status_id', '=', $selected_status]] : ['store_id' => $store->id]);
            $requests = $this->repo->all($this->columns,$this->with,$where,['id' => 'DESC'],10,$page);
            return view('accont.sales', compact('requests', 'request_status', 'selected_status'));
        }
        flash('Você ainda não possui uma Loja!', 'warning');
        return redirect()->route('accont.salesman.stores');

    }

    public function create(Category $category){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
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
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        $request = $this->repo->get($id,$this->columns,$this->with);
        if($request->store->id == Auth::user()->salesman->store->id){
            if($request->visualized_store === 0){
                $request->fill(['visualized_store' =>1])->save();
            }
            return view('accont.sale_info', compact('request','rastreamento'));
        }

    }

    public function tracking_code(Request $req, $id){

        $this->validate($req,[
            'tracking_code' => 'required'
        ],['tracking_code.required' => 'O código de rastreio é obrigatório']);

        if(!track_object($req->tracking_code, $id)['message']){
            if($request = $this->repo->update(['tracking_code'=>$req->tracking_code, 'request_status_id' => 4],$id)){
                flash('Código de rastreamento do correio salvo', 'accept');
                return redirect()->route('accont.salesman.sale_info', ['id' => $id]);
            }

            flash('Erro ao salvar o código do correio', 'error');
            return redirect()->route('accont.salesman.sale_info', ['id' => $id]);
        }
        flash('Código de rastreio inválido', 'error');
        return redirect()->route('accont.salesman.sale_info', ['id' => $id]);
    }

    public function update(){

    }

    public function tag($id){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        if($request = $this->repo->get($id,$this->columns,$this->with)){
            $store = Store::with(['adress'])->find($request->store->id);
            $pdf = PDF::loadView('layouts.parties.etiqueta',['request' => $request,'store'=> $store]);
            return $pdf->inline($request->key.'.pdf');
        }

    }

    private function status_request(){
        $store = Auth::user()->salesman->store;
        $req_freights = $store->requests->where('request_status_id',4);
        $req_freights->each(function($request){
            $status_freigth = Correios::rastrear($request->zip_code);
            if($status_freigth[0]['status'] === 'Entrega Efetuada'){
                $request->fill(['request_status_id' => 5])->save();
            }
            return $request;
        });
    }
}