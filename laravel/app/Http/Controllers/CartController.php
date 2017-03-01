<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 27/02/2017
 * Time: 17:11
 */

namespace App\Http\Controllers;
use App\Model\Cart;
use App\Repositories\Accont\RequestsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected  $cart;
    public function __construct() {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $this->cart = new Cart($oldCart);
    }

    public function index(){
        $cart = Session::has('cart') ? Session::get('cart') : null;
        return view('pages.cart', compact('cart'));
    }

    public function add_product(Request $request, $id){
        $cart = $this->cart->add_cart($id);
        $request->session()->put('cart', $cart);
        return redirect()->route('pages.cart');
    }

    public function remove_product (Request $request, $id){
        $cart = $this->cart->remove_product($id);
        $request->session()->put('cart', $cart);
        return redirect()->route('pages.cart');
    }

    public function update_qtd(Request $request, $id){
        $cart = $this->cart->update_qtd_product($request->qtd, $id);
        $request->session()->put('cart', $cart);
        return response()->json(compact('cart'),200);
    }

    public function add_obs(Request $request, $id){
        $cart = $this->add_obs($request->obs, $id);
        $request->session()->put('cart', $cart);
        return redirect()->route('pages.cart');
    }

}