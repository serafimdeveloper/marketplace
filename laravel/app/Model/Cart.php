<?php

namespace App\Model;

class Cart
{
    /**
     * propriedade da classe
     *
     */
     public $amount = 0;
     public $address = [];
     public $stores = [];

    public function __construct($oldcart){
        if($oldcart){
            $this->address = $oldcart->address;
            $this->stores = $oldcart->stores;
        }
    }

    public function add_cart($id){
        $product = Product::find($id);
        $storedItem = ['name' => $product->name, 'qtd' => 0, 'price_unit' => isset($product->price_out_discount) ? $product->price_out_discount : $product->price, 'subtotal'=> 0, 'image'=>$product->galeries->first()->image  ];
        $store = $product->store;
        if(array_key_exists($store->id, $this->stores)){
            if(array_key_exists($id, $this->stores[$store->id]['products'])){
                $storedItem = $this->stores[$store->id]['products'][$id];
            }
        }
        $storedItem['qtd']++;
        $storedItem['subtotal'] = $storedItem['price_unit'] * $storedItem['qtd'];
        $storedItem['freight'] = 0;
        $this->stores[$store->id]['name'] = $store->name;
        $this->stores[$store->id]['products'][$id] = $storedItem;
        $this->amount_price();
    }

    private function amount_price(){
        foreach($this->stores as $key => $store){
            $subtotal = 0;
            foreach($store['products'] as $product){
                $subtotal+= $product['subtotal'];
            }
            $this->stores[$key]['subtotal'] = $subtotal;
            $this->amount+= $subtotal;
        }
    }
}
