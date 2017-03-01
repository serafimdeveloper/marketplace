<?php

namespace App\Model;

class Cart
{
    /**
     * propriedade da classe
     *
     */
     public $amount = 0;
     public $count = 0;
     public $address = [];
     public $stores = [];

    public function __construct($oldcart){
        if($oldcart){
            $this->address = $oldcart->address;
            $this->stores = $oldcart->stores;
            $this->count = $oldcart->count;
            $this->address = $oldcart->address;
        }
    }

    public function add_cart($id){
        $product = Product::find($id);
        $storedItem = ['name' => $product->name, 'qtd' => 0,
            'price_unit' => isset($product->price_out_discount) ? $product->price_out_discount : $product->price,
            'subtotal' => 0, 'image' => $product->galeries->first()->image, 'obs' => ''];
        $store = $product->store;
        if(array_key_exists($store->id, $this->stores)){
            if(array_key_exists($id, $this->stores[$store->id]['products'])){
                $storedItem = $this->stores[$store->id]['products'][$id];
            }
        }
        $storedItem['qtd']++;
        $storedItem['subtotal'] = $storedItem['price_unit'] * $storedItem['qtd'];
        $this->stores[$store->id]['name'] = $store->name;
        $this->stores[$store->id]['products'][$id] = $storedItem;
        $this->amount_price();
    }

    public function remove_product($id){
        $product = Product::find($id);
        $store = $product->store;

        if(array_key_exists($product->store_id, $this->stores)){
            if(array_key_exists($id, $this->stores[$store->id]['products'])){
                unset($this->stores[$store->id]['products'][$id]);
                $this->amount_price();
            }
        }
    }

    public function update_qtd_product($qtd, $id)
    {
        $product = Product::find($id);
        if (array_key_exists($product->store_id, $this->stores)) {
            if (array_key_exists($id, $this->stores[$product->store_id]['products'])) {
                $this->stores[$product->store_id]['products'][$id]['qtd'] = $qtd;
                $this->amount_price();
            }
        }
    }

    public function add_obs($obs, $id)
    {
        $product = Product::find($id);
        if (array_key_exists($product->store_id, $this->stores)) {
            if (array_key_exists($id, $this->stores[$product->store_id]['products'])) {
                $this->stores[$product->store_id]['products'][$id]['obs'] = $obs;
            }
        }
    }

    private function amount_price(){
        $count = 0;
        foreach($this->stores as $key => $store){
            $subtotal = 0;
            foreach($store['products'] as $product){
                $subtotal+= $product['subtotal'];
                $count+= $product['qtd'];
            }
            $this->stores[$key]['subtotal'] = $subtotal;
            $this->amount+= $subtotal;
            $this->count = $count;
        }
    }
}
