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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index(){
        $addresses = (isset(Auth::user()->addresses) ? Auth::user()->addresses->pluck('name','zip_code') : null);
        $freight = Freight::where('name', '!=', 'Frete Grátis')->pluck('name','code');
        $cart = Session::has('cart') ? Session::get('cart') : null;
        return view('pages.cart', compact('cart', 'addresses', 'freight'));
    }

    public function add_product(Request $request, $id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add_cart($id);
        $request->session()->put('cart', $cart);
        if($request->ajax()){
            return redirect()->json(compact('cart'), 201);
        }
        return redirect()->route('pages.cart');
    }

    public function remove_product (Request $request, $id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->remove_product($id);
        $request->session()->put('cart', $cart);
        return response()->json(['msg'=>'Produto removido com sucesso!'], 200);
    }

    public function update_qtd(Request $request){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $obj = new Cart($oldCart);
        if($cart =  $obj->update_qtd_product($request->qtd, $request->product)){
            $request->session()->put('cart', $cart);
            return response()->json(['msg' => 'Quantidade de produtos no carrinho atualizado com sucesso!'],200);
        }
        return response()->json(['msg' => 'Quantidade de produtos insuficiente!'],422);
    }

    public function add_obs(Request $request){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add_obs($request->note, $request->store);
        $request->session()->put('cart', $cart);
        return response()->json(['msg' => 'Observação salva com sucesso!'],200);
    }

    public function add_address(Request $request){
        $this->validate($request,['address'=>'required|regex:/^\d{5}-?\d{3}$/']);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add_address($request->address);
        $request->session()->put('cart', $cart);
        return redirect()->route('pages.cart');
    }

    public function type_freight(Request $request){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->change_type_freight($request->store, $request->type_freight);
        $request->session()->put('cart', $cart);
        return response()->json(['msg' => 'Tipo de Frete alterado!'],200);
    }

}