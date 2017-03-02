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
        return redirect()->route('pages.cart');
    }

    public function remove_product (Request $request, $id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->remove_product($id);
        $request->session()->put('cart', $cart);
        return redirect()->route('pages.cart');
    }

    public function update_qtd(Request $request, $id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->update_qtd_product($request->qtd, $id);
        $request->session()->put('cart', $cart);
        return response()->json(compact('cart'),200);
    }

    public function add_obs(Request $request, $id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add_obs($request->obs, $id);
        $request->session()->put('cart', $cart);
        return redirect()->route('pages.cart');
    }

}