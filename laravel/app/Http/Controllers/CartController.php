<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 27/02/2017
 * Time: 17:11
 */

namespace App\Http\Controllers;
use App\Model\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function index(){
        $addresses = (isset(Auth::user()->addresses) ? Auth::user()->addresses : null);
        $cart = Session::has('cart') ? Session::get('cart') : null;
        return view('pages.cart', compact('cart', 'addresses'));
    }

    public function add_product(Request $request, $id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add_cart($id);
        $request->session()->put('cart', $cart);
        return redirect()->route('pages.cart');
    }



}