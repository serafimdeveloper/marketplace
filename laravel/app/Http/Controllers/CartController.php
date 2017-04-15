<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 27/02/2017
 * Time: 17:11
 */

namespace App\Http\Controllers;
use App\Model\Cart;
use App\Model\Freight;
use App\Services\CartServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Correios;

class CartController extends Controller
{
    protected $cart_service;

    public function __construct(CartServices $cart_service){
        $this->cart_service = $cart_service;
    }

    public function index(Freight $model_freight){
        $addresses = (isset(Auth::user()->addresses) ? Auth::user()->addresses->pluck('name','id') : null);
        $freight = $model_freight->where('name', '!=', 'Frete Grátis')->pluck('name','code');
        $address = [];
        $cart = [];
        if(Session::has('cart') || isset(Auth::user()->cartsession->stores)){
            $cartDB = isset(Auth::user()->cartsession) ? Auth::user()->cartsession : null;
            $cartModelDB = ($cartDB) ? $this->cart_service->dbCart(json_decode($cartDB->address, true), json_decode($cartDB->stores, true))->getCart() : null;
            $oldCart = (Session::has('cart')) ?  Session::get('cart') : $cartModelDB;
            $cart = $this->cart_service->setCart($oldCart)->getCart();
            $address = isset($cart->address['zip_code']) ? Correios::cep($cart->address['zip_code']) : [];
        }
        return view('pages.cart', compact('cart', 'addresses', 'freight', 'address'));
    }

    public function add_product(Request $request, $id){
        if($this->cart_service->cantBuy($id)) {
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            $cart->add_cart($id);
            $request->session()->put('cart', $cart);
            if ($request->ajax()) {
                return response()->json(['msg' => 'Produto adicionado no carrinho com sucesso!', 'cart' => $cart->amount], 201);
            }
            return redirect()->route('pages.cart');
        }else{
            if($request->ajax()){
              return response()->json('Você não pode comprar esse produto',403);
            }
            flash('Você não pode comprar esse produto','error');
            return redirect()->back();
        }
    }

    public function remove_product (Request $request, $id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->remove_product($id);
        $request->session()->put('cart', $cart);
        return response()->json(['msg'=>'Produto removido do carrinho com sucesso!'], 200);
    }

    public function update_qtd(Request $request){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $obj = new Cart($oldCart);
        if($cart =  $obj->update_qtd_product($request->qtd, $request->product)){
            $request->session()->put('cart', $cart);
            return response()->json(['msg' => 'Quantidade de produtos no carrinho atualizado com sucesso!'],200);
        }
        return response()->json(['msg' => 'Quantidade de produtos insuficiente em estoque!'],422);
    }

    public function add_obs(Request $request){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add_obs($request->note, $request->store);
        $request->session()->put('cart', $cart);
        return response()->json(['msg' => 'Observação salva com sucesso!'],200);
    }

    public function add_address(Request $request){
        if($address = $request->address){
            $zip_code = Auth::user()->addresses->find($address)->zip_code;
        }else{
            $this->validate($request, ['zip_code' => 'required|regex:/^\d{5}-?\d{3}$/']);
            $zip_code = $request->zip_code;
            $address = null;
            if(!Correios::cep($zip_code)){
                flash('Cep inválido!', 'error');
                return redirect()->route('pages.cart');
             }
        }
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add_address(['id' => $address, 'zip_code' => $zip_code]);
        $request->session()->put('cart', $cart);
        return redirect()->route('pages.cart');
    }

    public function type_freight(Request $request){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->change_type_freight($request->store, ['name' => $request->type_freight, 'id' => $request->id]);
        $request->session()->put('cart', $cart);
        return response()->json(['msg' => 'Tipo de Frete alterado!'],200);
    }

}