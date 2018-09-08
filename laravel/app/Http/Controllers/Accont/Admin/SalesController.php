<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 12/04/2017
 * Time: 20:38
 */

namespace App\Http\Controllers\Accont\Admin;

use App\Repositories\Accont\RequestsRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class SalesController extends AbstractAdminController
{
    public function __construct(RequestsRepository $repo){
        $this->repo = $repo;
    }

    public function index(Request $request){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_accont');
        }
        $this->ordy = ['created_at' => 'DES'];
        $this->title = 'Vendas / Comissões';
        $this->with = ['store','user','type_freight','products','request_status'];
        $this->placeholder = 'Pesquisar pelo nome do cliente ou código do pedido';
        $data = $this->search($request, 'sales');
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }

    public function show($id){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_accont');
        }
        $this->with = ['user','store','products','request_status','type_freight'];
        if($result = $this->getByRepoId($id)){
            $result['address'] = $this->orderAddress($result);
            return view('layouts.parties.alert_sales_info', compact('result'));
        }
        return response()->json(['msg' => 'Erro ao encontrar a venda'],404);
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