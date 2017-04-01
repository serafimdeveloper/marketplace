<?php
namespace App\Services;
use App\Model\Cart;
use App\Model\Product;
use App\Model\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartServices
{
    protected $cart;

    public function setCart($cart){
        $this->cart = $cart;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCart()
    {
        return $this->cart;
    }

    public function check_cart(){
        foreach($this->cart->stores as $key_store => $store){
            foreach ($store['products'] as $key_product =>  $product){
                if($prod = Product::find($key_product)){
                    if($prod->quantity < $product['qtd']){
                        unset($store['products'][$key_product]);
                    }
                    $product['price_unit'] = isset($prod->price_out_discount) ? $prod->price_out_discount : $prod->price;
                    $product['subtotal'] = $product['price_unit'] * $product['qtd'];
                }else{
                    unset($store['products'][$key_product]);
                }
                $this->cart->stores[$key_store]['products'][$key_product] = $product;
            }
        }
        $this->cart->calc_freight();
        $this->saveCart();
        return $this;
    }

    public function requests(array $with){
        $requests = [];
        foreach ($this->cart->stores as $store){
            $requests[] = Request::with($with)->find($store['request']);
        }
        return $requests;
    }

    public static function getStores($hash){
        foreach(Session::get('cart')->stores as $key => $value){
            if(strtoupper(sha1($key)) === $hash){
                return Session::get('cart')->stores[$key];
            }
        }
    }

    public function deleteRequestCart($store){
        if(array_key_exists($store, $this->cart->stores)){
            unset($this->cart->stores[$store]);
            if(!count($this->cart->stores)){
                Session::forget('cart');
            }
        }
        return $this;
    }

    public function dbCart($address, $stores){
        $this->cart = new Cart();
        $this->cart->address = $address;
        $this->cart->stores  = $stores;
        return $this;
    }

    public function saveCart(){
        if(Auth::check()){
            $user = Auth::user();
            if($this->cart->stores){
                if($session = $user->cartsession){
                    $session->fill(['address' => json_encode($this->cart->address), 'stores' => json_encode($this->cart->stores)])->save();
                }else{
                    $user->cartsession()->create(['address' => json_encode($this->cart->address), 'stores' => json_encode($this->cart->stores)]);
                }
                Session::put('cart', $this->cart);
            } else{
                if($session = $user->cartsession){
                    $session->delete();
                }
            }
        }else{
            Session::put('cart', $this->cart);
        }
    }
}