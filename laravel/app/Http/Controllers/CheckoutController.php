<?php

namespace App\Http\Controllers;

use App\Http\Requests\Accont\AdressesStoreRequest;
use App\Repositories\Accont\RequestsRepository;
use Artesaos\Moip\facades\Moip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Correios;
use App\Repositories\Accont\AdressesRepository;

class CheckoutController extends Controller{
    protected $repo_address, $repo_request;

    function __construct(AdressesRepository $repo_address, RequestsRepository $repo_request){
        $this->repo_address = $repo_address;
        $this->repo_request = $repo_request;
    }

    public function confirmAddress(){
        if(Session::has($cart = 'cart')){
            $cart = Session::get('cart');
            if(isset($cart->address['id'])){
                $address = $this->repo_address->get($cart->address['id']);
            }else{
                $address = (object) Correios::cep($cart->address)[0];
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
            if(isset($cart->address['id'])){
                $address = $this->repo_address->update($req->all(),$cart->address['id']);
            }else{
                $address = $this->repo_address->store($req->all());
                $cart->add_address(['id' =>$address->id, 'zip_code' => $address->zip_code]);
            }
            foreach($cart->stores as $key_store => $store){
                $dados = [
                    'user_id' => $user->id, 'adress_id' => $address->id, 'store_id' => $key_store, 'request_status_id' => 2, 'key'=> generate_key(),
                    'freight_price' => $store['freight'][$store['type_freight']['name']]['val'], 'amount' =>$store['amount'],
                    'note' => $store['obs']
                ];
                if(isset($store['request'])){
                    $request =  $this->repo_request->update($dados,$store['request']);
                }else{
                    $request =  $this->repo_request->store($dados);
                    $cart->add_request($key_store, $request->id);
                }
                foreach($store['products'] as $key_product => $product){
                    $request->products()->sync([$key_product => ['quantity'=> $product['qtd'], 'unit_price' => $product['price_unit'],
                    'amount' => $product['subtotal']]]);
                }
            }
            flash('Confirmação de Endereço realizada com sucesso','accept');
            return redirect()->route('pages.cart.cart_checkout');
        }
        flash('Ocorreu um erro ao confirmar o endereço','error');
        return redirect()->route('cart.cart_address');
    }

    public function checkout(){
        if(Session::has('cart')){
            $cart = Session::get('cart');
            if(isset($cart->address['id'])){
                return view('pages.cart_checkout');
            }
        }
    }
}
