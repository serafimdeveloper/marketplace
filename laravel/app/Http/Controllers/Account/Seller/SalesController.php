<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 31/01/2017
 * Time: 14:48
 */

namespace App\Http\Controllers\Account\Sellers;


use App\Http\Controllers\AbstractController;
use App\Model\RequestStatus;
use App\Model\Store;
use App\Repositories\Account\RequestsRepository;
use App\Model\Category;
use App\Http\Requests\Account\Seller\ProductsStoreRequest;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use PDF;
use App\Services\CorreiosService as Correios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SalesController extends AbstractController
{
    protected $with = ['user','store','products','type_freight','request_status'];

    public function repo(){
        return RequestsRepository::class;
    }

    public function index(Request $req){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
        $request_status = RequestStatus::pluck('description', 'id');
        $selected_status = (isset($req->all()['status']) ? (int) $req->all()['status'] : null);
        $page = Input::get('page');
        if($store = Auth::user()->seller->store) {
            $this->status_request();
            $where = ($selected_status ? [['store_id', '=', $store->id], ['request_status_id', '=', $selected_status]] : ['store_id' => $store->id]);
            $requests = $this->repo->withTrashed()->all($this->columns,$this->with,$where,['id' => 'DESC'],10,$page);
            return view('account.sales', compact('requests', 'request_status', 'selected_status'));
        }
        flash('Você ainda não possui uma Loja!', 'warning');
        return redirect()->route('account.seller.stores');

    }

    public function create(Category $category){
        $categories = $category->pluck('name','id');
        return view('account.product_info', compact('categories'));
    }

    public function store(ProductsStoreRequest $request){
        $store  = Auth::user()->seller->store;
        $dados = $request->except(['image_master', 'image']);
        $dados['store_id'] = $store->id;
        if($product = $this->repo->store($dados)){

        }
    }

    public function edit($id){
        $request = $this->repo->withTrashed()->get($id,$this->columns,$this->with);
        if($request->store->id == Auth::user()->seller->store->id){
            $address = $this->orderAddress($request);
            if($request->visualized_store === 0){
                $request->fill(['visualized_store' => 1])->save();
            }
            $type = ['type' => 'request', 'id' => $request->id];
            return view('account.sale_info', compact('request', 'type', 'address'));
        }

    }

    public function tracking_code(Request $req, $id){

        $this->validate($req, [
            ['tracking_code' => 'required'],
            ['tracking_code.required' => 'O código de rastreio é obrigatório']
        ]);

        if(!track_object($req->tracking_code, $id)['message']){
            if($request = $this->repo->update(['tracking_code' => $req->tracking_code, 'request_status_id' => 4],$id)){
                flash('Código de rastreamento do correio salvo', 'accept');
                return redirect()->route('account.seller.sale_info', ['id' => $id]);
            }

            flash('Erro ao salvar o código do correio', 'error');
            return redirect()->route('account.seller.sale_info', ['id' => $id]);
        }
        flash('Código de rastreio inválido', 'error');
        return redirect()->route('account.seller.sale_info', ['id' => $id]);
    }

    public function update(){

    }

    public function tag($id){
        if(Gate::denies('is_active')) {
            return redirect()->route('page.confirm_account');
        }
        if($request = $this->repo->get($id,$this->columns,$this->with)) {
            $store = Store::find($request->store->id);
            $address = $this->orderAddress($request);
            $pdf = PDF::loadView('layouts.parties.etiqueta',['request' => $request,'store'=> $store, 'address' => $address]);
            return $pdf->inline($request->key.'.pdf');
        }

    }

    private function status_request() {
        $store = Auth::user()->seller->store;
        $req_freights = $store->requests->where('request_status_id', 4);
        $correios = $this->app->make(Correios::class);
        $req_freights->each(function($request) use($correios){
            $status_freigth = $correios->rastrear($request->tracking_code);
            if($status_freigth[0]['status'] === 'Entrega Efetuada'){
                $request->fill(['request_status_id' => 5])->save();
            }
            return $request;
        });
    }

    /**
     * Retorna endereços de uma ordem de pedido
     * @param $order
     * @return mixed
     */
    private function orderAddress($order){
        $address['receiver'] = json_decode($order->address_receiver);
        $address['sender'] = json_decode($order->address_sender);
        return $address;
    }
}