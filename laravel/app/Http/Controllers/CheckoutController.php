<?php

namespace App\Http\Controllers;

use App\Http\Requests\Accont\AdressesStoreRequest;
use App\Package\Moip\lib\MoIPClient;
use App\Repositories\Accont\AdressesRepository;
use App\Repositories\Accont\RequestsRepository;
use App\Repositories\Accont\StoresRepository;
use App\Services\CartServices;
use App\Services\PaymentMoip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Correios;
use DB;

class CheckoutController extends Controller {
    private $moip, $address;
    protected $repo_address, $repo_stores, $service, $repo;
    protected $with = ['user', 'adress', 'freight', 'payment', 'requeststatus', 'products', 'store', 'movementstocks'];

    function __construct(AdressesRepository $repo_address, StoresRepository $repo_stores, CartServices $service, RequestsRepository $repo){
        $this->repo_address = $repo_address;
        $this->repo_stores = $repo_stores;
        $this->service = $service;
        $this->repo = $repo;
    }

    public function confirmAddress(Request $request){
        $user = Auth::user();
        if(Session::has('cart')){
            $cart = Session::get('cart');
            foreach($cart->stores as $key => $values){
                if($request->sha1 === strtoupper(sha1($key))){
                    $sha1 = $request->sha1;
                    if($cart->address['id']){
                        $address = $this->repo_address->get($cart->address['id']);
                    }else{
                        $address = (object)Correios::cep($cart->address['zip_code'])[0];
                    }

                    return view('pages.cart_address', compact('address', 'sha1', 'user'));
                }
            }
        }
        flash('Não tem nenhum carrinho', 'error');

        return redirect()->back();
    }

    public function confirmPostAddress(AdressesStoreRequest $req, $sha1){
        if(Session::has('cart')){
            $cart = Session::get('cart');
            foreach($cart->stores as $key => $store){
                if($sha1 === strtoupper(sha1($key))){
                    $user = Auth::user();
                    DB::beginTransaction();
                    try{
                        $address = $user->addresses->where('name', $req->name)->where('zip_code', $req->zip_code)->first();
                        if(!$address){
                            $address = $user->addresses()->create($req->all());
                        }
                        $cart->add_address(['id' => $address->id, 'zip_code' => $address->zip_code, 'phone' => $req->phone]);
                        $dados = ['user_id' => $user->id, 'adress_id' => $address->id, 'freight_id' => $store['type_freight']['id'], 'phone' => $req->phone, 'request_status_id' => 2, 'key' => generate_key(), 'freight_price' => $store['freight'][ $store['type_freight']['name'] ]['val'], 'deadline' => $store['freight'][ $store['type_freight']['name'] ]['deadline'], 'amount' => $store['amount'], 'note' => $store['obs']];
                        $model_store = $this->repo_stores->get($key);
                        $request = $model_store->requests()->create($dados);
                        $cart->add_request($key, $request->id);
                        $request->products()->sync($this->products($store));
                        $this->service->setCart($cart)->deleteRequestCart($key)->saveCart();
                        DB::commit();

                        return redirect()->route('pages.cart.cart_order', ['order_key' => $request->key]);
                    }catch(\Exception $e){
                        DB::rollback();
                        flash('Ocorreu um erro ao confirmar o endereço', 'error');
                        redirect()->route('cart.cart_address');
                    }
                }
            }
        }
        redirect()->route('pages.cart');
    }

    private function products($store){
        $products = [];
        foreach($store['products'] as $key_product => $product){
            $products[ $key_product ] = ['quantity' => $product['qtd'], 'unit_price' => $product['price_unit'], 'amount' => $product['subtotal']];
        }

        return $products;
    }

    public function order($order_key){
        $order = $this->repo->order($this->with, $order_key);
        if($order){
            if($moip = $order->moip){
                $tokenmoip = $moip->token;
            }else{
                $payment = new PaymentMoip($order);
                $moip = $order->moip()->create(['request_id' => $order->id, 'token' => $payment->getToken()]);
                $tokenmoip = $moip->token;
            }
            $deadline = $this->max_deadline($order->products);

            return view('pages.cart_checkout', compact('order', 'tokenmoip', 'order_key', 'deadline'));
        }

        return redirect()->route('pages.cart');
    }

    public function updateOrder(Request $request){
        $order = \App\Model\Request::where('key', '=', $request->order)->first();
        if(!isset($request->response['Status'])){
            $order->fill(['request_status_id' => 1, 'payment_reference' => 'boleto'])->save();
            $order->moip->fill(['url' => $request->response['url']])->save();
        }else{
            if($request->response['Status'] == 'Autorizado'){
                $order->fill(['request_status_id' => 3, 'payment_reference' => 'cartão'])->save();
                $order->products->each(function($product){
                    $product->decrement('quantity', $product->requests->pivot->quantity);
                });
            }elseif($request->response['Status'] == 'Cancelado'){
                $order->fill(['request_status_id' => 8, 'payment_reference' => 'cartão'])->save();
            }else{
                $order->fill(['request_status_id' => 1, 'payment_reference' => 'cartão'])->save();
            }
            $order->moip->fill(['codeMoip' => $request->response['CodigoMoIP'], 'codeReturn' => $request->response['CodigoRetorno']])->save();
        }
        if(isset($request->response['url'])){
            $gerarBoleto = file_get_contents($request->response['url']);
        }


        $order_moip = new MoIPClient;
        $consult_result = $order_moip->curlGet(env('MOIP_TOKEN') . ":" . env('MOIP_KEY'), env('MOIP_URL') . '/ws/alpha/ConsultarInstrucao/' . $order->moip->token);
        $xml = simplexml_load_string($consult_result->xml);
        $infoMoip = $xml->RespostaConsultar;
        $moip['valueTodalRementente'] = (float) ($infoMoip->Autorizacao->Pagamento->ValorLiquido - $infoMoip->Autorizacao->Pagamento->Comissao->Valor);
        $moip['comission'] = (float) $infoMoip->Autorizacao->Pagamento->Comissao->Valor;
        $moip['taxamoip'] = (float) $infoMoip->Autorizacao->Pagamento->TaxaMoIP;

        $data = ['user' => Auth::user(), 'store' => $order->store, 'address' => $order->adress, 'products' => $order->products, 'request' => $order, 'moip' => $moip];
        $this->send_email('client', 'emails.requested_request', $data, 'Você enviou um pedido para a loja ' . $order->store->name);
        $this->send_email('store', 'emails.received_request', $data, 'Você recebeu um pedido do cliente ' . Auth::user()->name);
    }

    public function notification(Request $request, RequestsRepository $rp){
        $order = $rp->order(['moip', 'user'], $request->id_transacao);
        $amount = number_format($order->amount, 2, '', '');
        $st = $order->request_status_id;
        if(($request->valor == $amount) && ($order->user->email == $request->email_consumidor)){
            if($request->status_pagamento == 4){
                $st = 3;
                $data = ['user' => Auth::user(), 'store' => $order->store, 'products' => $order->products, 'request' => $order];
                $this->send_email('client', 'emails.customer.confirmation', $data, 'Pagamento efetuado com sucesso ' . $order->store->name);
                $this->send_email('store', 'emails.merchants.confirmation', $data, 'Pagamento recebido ' . Auth::user()->name);
            }elseif($request->status_pagamento == 5){
                $st = 6;
            }
        }
        $rp->update(['request_status_id' => $st], $order->id);
    }

    private function send_email($type, $template, $data, $subject){
        $data['email'] = ($type === 'client') ? $data['user']->email : $data['store']->salesman->user->email;
        $data['name'] = ($type === 'client') ? $data['user']->name : $data['store']->salesman->user->name;
        send_mail($template, $data, $subject);
    }

    private function max_deadline($products){
        $products = $products->map(function($product){
            return $product->deadline;
        });

        return $products->max();
    }
}