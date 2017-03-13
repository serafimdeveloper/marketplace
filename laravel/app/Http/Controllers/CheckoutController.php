<?php

namespace App\Http\Controllers;

use App\Http\Requests\Accont\AdressesStoreRequest;
use App\Model\Moip;
use App\Repositories\Accont\StoresRepository;
use App\Services\CartServices;
use App\Services\PaymentMoip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Correios;
use App\Repositories\Accont\AdressesRepository;

class CheckoutController extends Controller{
    private $moip, $address;
    protected $repo_address, $repo_stores, $service;
    protected $with = ['user','adress','freight','payment','requeststatus','products','store','movementstocks'];

    function __construct(AdressesRepository $repo_address, StoresRepository $repo_stores, CartServices $service){
        $this->repo_address = $repo_address;
        $this->repo_stores = $repo_stores;
        $this->service = $service;
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
        flash('Não tem nenhum carrinho','error');
        return redirect()->back();
    }

    public function confirmPostAddress(AdressesStoreRequest $req, $sha1){
        $user = Auth::user();
        if(Session::has('cart')){
            $cart = Session::get('cart');
            foreach($cart->stores as $key => $values){
                if( $sha1 === strtoupper(sha1($key))){
                    $user = Auth::user();
                    if($model_address = $user->addresses->where('name',$req->name)->first()){
                        $model_address->fill($req->all());
                        $address = $user->addresses()->save($model_address);
                    }else{
                        $address = $user->addresses()->create($req->all());
                    }
                    $cart->add_address(['id' =>$address->id, 'zip_code' => $address->zip_code, 'phone' => $req->phone]);
                    foreach($cart->stores as $key_store => $store){
                        $dados = [
                            'user_id' => $user->id, 'adress_id' => $address->id,'freight_id' => $store['type_freight']['id'], 'request_status_id' => 2, 'key'=> generate_key(),
                            'freight_price' => $store['freight'][$store['type_freight']['name']]['val'], 'amount' =>$store['amount'],
                            'note' => $store['obs']
                        ];
                        $model_store = $this->repo_stores->get($key_store);
                        if(isset($store['request'])){
                            $model_request = $model_store->requests->find($store['request'])->fill($dados);
                            $request = $model_store->requests()->save($model_request);
                        }else{
                            $request =  $model_store->requests()->create($dados);
                        }
                        $cart->add_request($key_store, $request->id);
                        $request->products()->sync($this->products($store));
                        if($user->phone != $req->phone){
                            $user->phone = $req->phone;
                            $user->save();
                        }
                    }
                    Session::put('cart', $cart);
                    return redirect()->route('pages.cart.cart_order', ['order_key' => $request->key]);


//                    $payment = new PaymentMoip(CartServices::getStores($sha1), $cart->address);
//                    if($endpoint = $payment->getEndpoint()){
//                        return view('pages.cart_address', compact('address', 'sha1', 'endpoint'));
//                    }
//                    flash('Ocorreu um erro não será possível continuar esse procedimento, Contate nos e tente novamente mais tarde!','error');
//                    return redirect()->back();
                }
            }
        }
        redirect()->route('pages.cart');
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

    public function order($order_key){
        $order = \App\Model\Request::where('key', '=', $order_key)->first();

        if(!isset($order->moip[0]->token)){
            $payment = new PaymentMoip($order);
            $payment->send();
            $order->moip()->create(['request_id' => $order->id, 'token' => $payment->getToken()]);
        }


        $tokenmoip = $order->moip[0]->token;

//        $payment = new PaymentMoip($order);

        return view('pages.cart_checkout', compact('order', 'tokenmoip'));
    }

    public function boleto($order_key){
        $order = \App\Model\Request::where('key', '=', $order_key)->first();
        $payment = new PaymentMoip($order);
        $payment->send();

        return view('pages.cart_checkout_boleto');
    }

    public function payment(){

    }

    public function callback(){

        return view('accont.payment_callback');
    }

    public function notification(){
    }

    public function updateOrder(){

    }
}
