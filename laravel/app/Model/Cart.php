<?php

namespace App\Model;

class Cart
{
    /**
     * propriedade da classe
     * @var $amount
     * @var $count
     * @var $address
     * @var $stores
     */
    public $amount = 0;
    public $count = 0;
    public $address = [];
    public $stores = [];

    /** Metodo construtor instancia o objeto
     *  @param $oldcart
     */
    public function __construct($oldcart){
        if($oldcart){
            $this->address = $oldcart->address;
            $this->stores  = $oldcart->stores;
            $this->count   = $oldcart->count;
            $this->amount  = $oldcart->amount;
        }
    }

    /** Adiciona o produto no carrinho e cria loja caso não houver
     *  @param $id
     */
    public function add_cart($id){
        $product = Product::find($id);
        $storedItem = ['name' => $product->name, 'qtd' => 0,
            'price_unit' => isset($product->price_out_discount) ? $product->price_out_discount : $product->price,
            'subtotal' => 0, 'image' => $product->galeries->first()->image, 'slug' => $product->slug,
            'free_shipping' => $product->free_shipping, 'category' => $product->category->slug];
        $store = $product->store;
        if(array_key_exists($store->id, $this->stores)){
            if(array_key_exists($id, $this->stores[$store->id]['products'])){
                $storedItem = $this->stores[$store->id]['products'][$id];
            }
        }
        $storedItem['qtd']++;
        $storedItem['subtotal'] = $storedItem['price_unit'] * $storedItem['qtd'];
        $this->stores[$store->id]['name'] = $store->name;
        $this->stores[$store->id]['slug'] = $store->slug;
        $this->stores[$store->id]['type_freight']['id'] =  isset($this->stores[$store->id]['type_freight']['id']) ?  $this->stores[$store->id]['type_freight']['id'] : 'PAC';
        $this->stores[$store->id]['type_freight']['name'] =  isset($this->stores[$store->id]['type_freight']['name']) ?  $this->stores[$store->id]['type_freight']['name'] : 'PAC';
        $this->stores[$store->id]['obs'] = isset($this->stores[$store->id]['obs']) ? $this->stores[$store->id]['obs'] : null;
        $this->stores[$store->id]['products'][$id] = $storedItem;
        $this->calc_freight();
        $this->price_freight($store->id);
        $this->amount_price();

    }

    /** remove o produto do carrinho e a loja caso não houver nenhum produto
     *  @param $id
     */
    public function remove_product($id){
        $product = Product::find($id);
        $store = $product->store;

        if(array_key_exists($product->store_id, $this->stores)){
            if(array_key_exists($id, $this->stores[$store->id]['products'])){
                unset($this->stores[$store->id]['products'][$id]);
                if(count($this->stores[$store->id]['products']) < 1){
                    unset($this->stores[$store->id]);
                }else{
                    $this->calc_freight();
                    $this->price_freight($store->id);
                }
                $this->amount_price();
            }
        }
    }

    /**
     * Atualiza a quantidade  do produtos especifico no carrinho
     * @param $qtd
     * @param $id
     * @return $this|bool
     */
    public function update_qtd_product($qtd, $id) {
        $product = Product::find($id);
        if (array_key_exists($product->store_id, $this->stores)) {
            if (array_key_exists($id, $this->stores[$product->store_id]['products'])) {
                if($product->quantity >= $qtd){
                    $this->stores[$product->store_id]['products'][$id]['qtd'] = $qtd;
                    $this->stores[$product->store_id]['products'][$id]['subtotal'] = $this->stores[$product->store_id]['products'][$id]['price_unit'] * $qtd;
                    $this->calc_freight();
                    $this->price_freight($product->store_id);
                    $this->amount_price();
                    return $this;
                }else{
                    return false;
                }
            }
        }
    }

    /** Adiciona a observação no pedido da loja especifica
     *  @param $obs
     *  @param $id
     */
    public function add_obs($obs, $id) {
        if (array_key_exists($id, $this->stores)) {
            $this->stores[$id]['obs'] = $obs;
        }
        $this->amount_price();
    }

    /** Adiciona o endereço na sessão do carrinho
     *  @param $address
     */
    public function add_address($address){
        $this->address['id'] = $address['id'];
        $this->address['zip_code'] = $address['zip_code'];

        $this->calc_freight();
    }

    /** Muda o tipo de frete da loja especificada
     *  @param $store
     *  @param $type_freight
     */
    public function change_type_freight($store, $type_freight){
        $this->stores[$store]['type_freight']['id'] = $type_freight['id'];
        $this->stores[$store]['type_freight']['name'] = $type_freight['name'];
        $this->price_freight($store);
        $this->amount_price();
    }

    /** Calcula o valores do carrinho */
    private function amount_price(){
        $count = 0;
        $amount = 0;
        foreach($this->stores as $key => $store){
            $subtotal = 0;
            foreach($store['products'] as $product){
                $subtotal+= $product['subtotal'];
                $count+= $product['qtd'];
            }
            $this->stores[$key]['subtotal'] = $subtotal;
            $this->stores[$key]['amount'] = $subtotal + $this->stores[$key]['price_freight'];
            $amount+= $this->stores[$key]['amount'];
            $this->count = $count;
        }
        $this->amount = $amount;
    }

    /**
     * Seta na classe o endereço da loja
     * @param $store
     * @param $request
     */
    public function add_request($store, $request){
        $this->stores[$store]['request'] = $request;
    }

    /** Calcula o preço do frete
     *  @param $store
     */
    private function price_freight($store){

        if(isset($this->address['zip_code'])){
            $type_freight = $this->stores[$store]['type_freight']['name'];
            $this->stores[$store]['price_freight'] = $this->stores[$store]['freight'][$type_freight]['val'];
        }else{
            $this->stores[$store]['price_freight'] = 0;
        }
    }

    /** Traz os valores e o prazo de cada frete */
    private function calc_freight(){
        if(isset($this->address['zip_code'])){
            foreach(calculate_freight($this) as $store => $value){
                $this->stores[$store]['freight'] = $value;
            }
        }
    }
}
