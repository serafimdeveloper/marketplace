<?php

namespace App\Http\Controllers;

use App\Http\Requests\Accont\AdressesStoreRequest;
use App\Repositories\Accont\RequestsRepository;
use App\Services\CartServices;
use Artesaos\Moip\facades\Moip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Correios;
use App\Repositories\Accont\AdressesRepository;

class CheckoutController extends Controller{
    private $moip;
    protected $repo_address, $repo_request, $service;
    protected $with = ['user','adress','freight','payment','requeststatus','products','store','movementstocks'];

    function __construct(AdressesRepository $repo_address, RequestsRepository $repo_request, CartServices $service){
        $this->moip = Moip::start();
        $this->repo_address = $repo_address;
        $this->repo_request = $repo_request;
        $this->service = $service;
    }

    public function order(Request $request){
        $order = $this->moip->orders()->setOwnId('seu_identificador_proprio')
            ->addItem('Descrição do pedido', 1, 'Mais info...', 10000)
            ->setShippingAmount(100)
            ->setCustomer($this->moip->customers()->setOwnId('seu_identificador_proprio_de_cliente')
                ->setFullname('Jose Silva')
                ->setEmail('nome@email.com')
                ->setBirthDate('1988-12-30')
                ->setTaxDocument('33333333333')
                ->setPhone(11, 66778899)
                ->addAddress('BILLING',
                    'Avenida Faria Lima', 2927,
                    'Itaim', 'Sao Paulo', 'SP',
                    '01234000', 8))
//            ->setCheckout()
            ->create();

        $ccNumber = '5555666677778884';
        $cvcNumber = '123';


        $payment = $order->payments()
            ->setCreditCard('05', '18', $ccNumber, $cvcNumber,
                $this->moip->customers()->setOwnId('sandbox_v2_1401147277')
                    ->setFullname('Jose Portador da Silva')
                    ->setEmail('fulano@email.com')
                    ->setBirthDate('1988-12-30')
                    ->setTaxDocument('33333333333')
                    ->setPhone(11, 66778899))
            ->execute();

        dd($payment->get('seu_identificador_proprio'));
        return view('test.integrationmoip');
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
                $cart->add_address(['id' =>$address->id, 'zip_code' => $address->zip_code]);
            }
            foreach($cart->stores as $key_store => $store){
                $dados = [
                    'user_id' => $user->id, 'adress_id' => $address->id, 'store_id' => $key_store, 'freight_id' => $store['type_freight']['id'], 'request_status_id' => 2, 'key'=> generate_key(),
                    'freight_price' => $store['freight'][$store['type_freight']['name']]['val'], 'amount' =>$store['amount'],
                    'note' => $store['obs']
                ];
                if(isset($store['request'])){
                    $request =  $this->repo_request->update($dados, $store['request']);
                }else{
                    $request =  $this->repo_request->store($dados);
                    $cart->add_request($key_store, $request->id);
                }
                foreach($store['products'] as $key_product => $product){
                    $request->products()->sync([$key_product => ['quantity'=> $product['qtd'], 'unit_price' => $product['price_unit'],
                    'amount' => $product['subtotal']]]);
                }
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
}
