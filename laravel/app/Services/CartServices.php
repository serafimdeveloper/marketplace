<?php
namespace App\Services;
use App\Model\Cart;
use App\Repositories\Accont\ProductsRepository;
use App\Repositories\Accont\RequestsRepository;
use Illuminate\Support\Facades\Session;

class CartServices
{
    protected $cart, $repo_product, $repo_request;

    public function __construct(ProductsRepository $repo_product, RequestsRepository $repo_request)
    {
        $this->repo_product = $repo_product;
        $this->repo_request = $repo_request;
    }

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
                if($prod = $this->repo_product->get($key_product)){
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
        Session::put('cart', $this->cart);
        return $this;
    }

    public function requests(array $with){
        $requests = [];
        dd($this->cart->stores);
        foreach ($this->cart->stores as $store){
            $requests[] = $this->repo_request->get($store['request'],['*'],$with);
        }
        return $requests;
    }

}