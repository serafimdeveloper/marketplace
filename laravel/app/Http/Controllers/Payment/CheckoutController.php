<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accont\AdressesStoreRequest;
use App\Repositories\Accont\StoresRepository;
use App\Services\CartServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Correios;
use App\Repositories\Accont\AdressesRepository;

class CheckoutController extends Controller{
    private $moip;
    protected $repo_address, $repo_stores, $service;
    protected $with = ['user','adress','freight','payment','requeststatus','products','store','movementstocks'];

    function __construct(AdressesRepository $repo_address, RequestsRepository $repo_request, CartServices $service){
        $this->repo_address = $repo_address;
        $this->repo_request = $repo_request;
        $this->service = $service;
    }

    public function repo(){

    }

    public function confirmAddress(){
        if(Session::has($cart = 'cart')){
            $cart = Session::get('cart');
            if($cart->address['id']){
                $address = $this->repo_address->get($cart->address['id']);
            }else{
                $address = (object) Correios::cep($cart->address['zip_code'])[0];
            }
            return view('pages.cart_address', compact('address'));
        }
        flash('Não tem nenhum carrinho','error');
        return redirect()->back();
    }

    public function confirmPostAddress(AdressesStoreRequest $req){
        if( Session::has('cart')){
            $user = Auth::user();

            $cart = Session::get('cart');
            if($cart->address['id']){
                $address = $this->repo_address->update($req->all(),$cart->address['id']);
            }else{
                $address = $this->repo_address->store($req->all());
            }
            $cart->add_address(['id' =>$address->id, 'zip_code' => $address->zip_code]);
            foreach($cart->stores as $key_store => $store){
                $dados = [
                    'user_id' => $user->id, 'adress_id' => $address->id,'freight_id' => $store['type_freight']['id'], 'request_status_id' => 2, 'key'=> generate_key(),
                    'freight_price' => $store['freight'][$store['type_freight']['name']]['val'], 'amount' =>$store['amount'],
                    'note' => $store['obs']
                ];

                $model_store = $this->repo_stores->get($key_store);
                if(isset($store['request'])){
                    $request = $this->repo_request->update($dados,$store['request']);
                    echo 'request atualizado' . $request->id . '</br>';
                }else{
                    $request = $this->repo_request->store($dados);
                }
                foreach($store['products'] as $key_product => $product){
                    $model_request = $model_store->requests->find($store['request']);
                    $request = $model_store->requests()->save($model_request);
                }
                $cart->add_request($key_store, $request->id);
                $request->products()->sync($this->products($store));
            }
            Session::put('cart', $cart);

            flash('Confirmação de Endereço realizada com sucesso','accept');
            return redirect()->route('pages.cart.cart_checkout');
        }
        flash('Ocorreu um erro ao confirmar o endereço','error');
        return redirect()->route('pages.cart.cart_address');
    }

    public function checkout(){
        if(Session::has('cart')){
            $cart = Session::get('cart');
            if(isset($cart->address['id'])){
                $requests = $this->service->setCart($cart)->requests($this->with);
                return view('pages.cart_checkout', compact('cart','requests'));
            }
            flash('Você não tem o endereço confirmado','error');
            redirect()->route('pages.cart.cart_address');
        }
        flash('Você não tem carrinho definido','error');
        redirect()->route('pages.cart');
    }

    private function products($store){
        $products = [];
        foreach ($store['products'] as $key_product => $product) {
            $products[$key_product] = ['quantity' => $product['qtd'], 'unit_price' => $product['price_unit'],
                'amount' => $product['subtotal']];
        }
        return $products;
    }
}
