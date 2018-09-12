<?php

namespace App\Model;

use App\Services\CorreiosService as Correios;

class Cart {
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
     * @param $oldcart
     */
    public function __construct($oldcart = null){
        if($oldcart){
            $this->address = $oldcart->address;
            $this->stores = $oldcart->stores;
            $this->count = $oldcart->count;
            $this->amount = $oldcart->amount;
        }
    }

    /** Adiciona o produto no carrinho e cria loja caso não houver
     * @param $id
     */
    public function add_cart($id){
        $product = Product::find($id);
        $storedItem = ['name' => $product->name, 'qtd' => 0, 'price_unit' => isset($product->price_out_discount) ? $product->price_out_discount : $product->price, 'subtotal' => 0, 'image' => $product->galleries->first()->image, 'slug' => $product->slug, 'free_shipping' => $product->free_shipping, 'category' => $product->category->slug];
        $store = $product->store;
        if(array_key_exists($store->id, $this->stores)){
            if(array_key_exists($id, $this->stores[ $store->id ]['products'])){
                $storedItem = $this->stores[ $store->id ]['products'][ $id ];
            }
        }
        $storedItem['qtd']++;
        $storedItem['subtotal'] = $storedItem['price_unit'] * $storedItem['qtd'];
        $this->stores[$store->id]['name'] = $store->name;
        $this->stores[$store->id]['slug'] = $store->slug;
        $type_freight_free = ($this->all_free_freigth($this->stores[$store->id])) ? true : false;
        $this->stores[$store->id]['type_freight']['id'] =  isset($this->stores[$store->id]['type_freight']['id']) ?  $this->stores[$store->id]['type_freight']['id'] :$type_freight_free  ? 3 : 2;
        $this->stores[$store->id]['type_freight']['name'] =  isset($this->stores[$store->id]['type_freight']['name']) ?  $this->stores[$store->id]['type_freight']['name'] : $type_freight_free ? 'FREE' : 'PAC';
        $this->stores[$store->id]['price_freight'] = isset($this->stores[$store->id]['price_freight']) ? $this->stores[$store->id]['price_freight'] : 0;
        $this->stores[$store->id]['obs'] = isset($this->stores[$store->id]['obs']) ? $this->stores[$store->id]['obs'] : null;
        $this->stores[$store->id]['products'][$id] = $storedItem;
        $this->calc_freight();
    }

    /** remove o produto do carrinho e a loja caso não houver nenhum produto
     * @param $id
     */
    public function remove_product($id){
        $product = Product::find($id);
        $store = $product->store;
        if(array_key_exists($product->store_id, $this->stores)){
            if(array_key_exists($id, $this->stores[ $store->id ]['products'])){
                unset($this->stores[ $store->id ]['products'][ $id ]);
                if(count($this->stores[ $store->id ]['products']) < 1){
                    if(isset($this->stores[ $store->id ]['request'])){
                        Request::destroy($this->stores[ $store->id ]['request']);
                    }
                    unset($this->stores[ $store->id ]);
                }
                $this->calc_freight();
            }
        }
    }

    /**
     * Atualiza a quantidade  do produtos especifico no carrinho
     * @param $qtd
     * @param $id
     * @return $this|bool
     */
    public function update_qtd_product($qtd, $id){
        $product = Product::find($id);
        if(array_key_exists($product->store_id, $this->stores)){
            if(array_key_exists($id, $this->stores[ $product->store_id ]['products'])){
                if($product->quantity >= $qtd){
                    $this->stores[ $product->store_id ]['products'][ $id ]['qtd'] = $qtd;
                    $this->stores[ $product->store_id ]['products'][ $id ]['subtotal'] = $this->stores[ $product->store_id ]['products'][ $id ]['price_unit'] * $qtd;
                    $this->calc_freight();

                    return $this;
                }else{
                    return false;
                }
            }
        }
    }

    /** Adiciona a observação no pedido da loja especifica
     * @param $obs
     * @param $id
     */
    public function add_obs($obs, $id){
        if(array_key_exists($id, $this->stores)){
            $this->stores[ $id ]['obs'] = $obs;
        }
    }

    /** Adiciona o endereço na sessão do carrinho
     * @param $address
     */
    public function add_address($address){
        $this->address['id'] = $address['id'];
        $this->address['zip_code'] = $address['zip_code'];
        $this->calc_freight();
    }

    /** Muda o tipo de frete da loja especificada
     * @param $store
     * @param $type_freight
     */
    public function change_type_freight($store, $type_freight){
        $this->stores[ $store ]['type_freight']['id'] = $type_freight['id'];
        $this->stores[ $store ]['type_freight']['name'] = $type_freight['name'];
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
                $subtotal += $product['subtotal'];
                $count += $product['qtd'];
            }
            $this->stores[ $key ]['subtotal'] = $subtotal;
            $this->stores[ $key ]['amount'] = $subtotal + $this->stores[ $key ]['price_freight'];
            $amount += $this->stores[ $key ]['amount'];
            $this->count = $count;
        }
        $this->amount = $amount;
    }

    /**
     * Seta na classe o pedido da loja
     * @param $store
     * @param $request
     */
    public function add_request($store, $request){
        $this->stores[ $store ]['request'] = $request;
    }

    /** Calcula o preço do frete
     * @param $store
     */
    private function price_freight($store){
        if(isset($this->address['zip_code'])){
            $type_freight = $this->stores[$store]['type_freight']['name'];
            if(!isset($this->stores[$store]['freight'][$type_freight])){
                $type_freight = $this->all_free_freigth($this->stores[$store]) ? 'FREE' : 'PAC';
                $this->stores[$store]['type_freight']['name'] = $type_freight;
            }
            $this->stores[ $store ]['price_freight'] = $this->stores[ $store ]['freight'][ $type_freight ]['val'];
        }else{
            $this->stores[ $store ]['price_freight'] = 0;
        }
    }

    /** Traz os valores e o prazo de cada frete */
    public function calc_freight(){
        if(isset($this->address['zip_code'])){
            foreach($this->calculate_freight() as $store => $value){
                $this->stores[$store]['freight'] = $value;
                if($this->stores[$store]['amount_free']){
                    unset($this->stores[$store]['freight']['PAC']);
                }
                $this->price_freight($store);
            }
        }
        $this->amount_price();
    }

    private function calculate_freight(){
        $data = [];
//
        /** Variáveis de dados a serem passados para o cáculo de frete */
        $df['formato'] = 'caixa';
        $df['diametro'] = 0;
        $df['cep_destino'] = preg_replace("/-/", '', $this->address['zip_code']);
        /* Opicionais */
        //      $df['empresa'] = '';
        //      $df['senha'] = '';
        //      $df['mao_propria'] = '';
        //      $df['valor_declarado'] = '';
        //      $df['aviso_recebimento'] = '';
        /**
         * Desmontar sessão para pegar informações do carrinho
         * Montar um array contendo informações básicas para o cálculo de frete
         * @var  $id
         * @var  $products
         */
        foreach($this->stores as $id => $store){
            $freights = TypeFreight::whereNotNull('code')->where('active', 1)->get();
            $correios = app()->make(Correios::class);
            foreach($freights as $freight){
                $volume = 0;
                $weight = 0;
                /** definir tipo para minusculo para comparar com biblioteca vendor de cálculo de frete */
                $df['tipo'] = trim(strtolower($freight->name));
                $this->stores[$id]['amount_free'] = $this->all_free_freigth($store);
                if($this->stores[$id]['amount_free']){
                    $volume = $this->stores[$id]['amount_free']['volume'];
                    $weight = $this->stores[$id]['amount_free']['weight'];
                }else{
                    /**
                     * Pegar cada produto para somar seu volume e obter peso total
                     * @var  $product_id
                     * @var  $product
                     */
                    foreach($store['products'] as $product_id => $product){
                        $product_data = Product::find($product_id);
                        /** Verifica se algum produto esta marcado como frete grátis, então zera seu valor */
                        if(!$product_data->free_shipping){
                            $volume += $product_data->width_cm * $product_data->length_cm * $product_data->height_cm * $product['qtd'];
                            $weight += $product_data->weight_gr * $product['qtd'];
                        }
                    }
                }
                /** @var  $volume - Arredondar para cima o valor do volume */
                $volume = ceil($volume);
                /** @var  $weight - transformar para Kilos */
                $weight = $weight / 1000;
                /** @var  $loop - Inicialização de loop caso para divisão de pacotes caso as regras de cálculo de frete não se aplique */
                $loop = 1;
                /** @var  $r3 - raíz Cúbica do volume total */
                $r3 = ceil(pow($volume, 1 / 3));
                /** Enquanto a soma da altura, largura e comprimento for maior que 200, divide o pacote em 2 */
                while($r3 * 3 >= 200){
                    $r3 = $r3 / 2;
                    $weight = $weight / 2;
                    $loop++;
                }
                $df['cep_origem'] = preg_replace("/-/", '', Store::find($id)->address['zip_code']);
                $df['comprimento'] = ($r3 < 16) ? 16 : $r3;
                $df['altura'] = ($r3 < 2) ? 2 : $r3;
                $df['largura'] = ($r3 < 11) ? 11 : $r3;
                $df['peso'] = ($weight < 0.3) ? 0.3 : $weight;
                /** @var  $i - Calcula o frete separadamente de acordo com a separação de pacotes */
                for($i = 0; $i < $loop; $i++){
                    /** Armazena cada cálculo */
                    $return[ $id ][ $freight->name ][] = $correios->frete($df);
                }
                /**
                 * Monta o array com informações a serem retornadas separadas pelo Id de cada loja
                 * @var  $key
                 * @var  $value
                 */
//                    dd($return);
                foreach($return as $key => $value){
                    $data[ $key ][ $freight->name ]['val'] = 0;
                    for($i = 0; $i < count($value[ $freight->name ]); $i++){
                        $data[ $key ][ $freight->name ]['val'] += $value[ $freight->name ][ $i ]['valor'];
                        $data[ $key ][ $freight->name ]['deadline'] = $value[ $freight->name ][ $i ]['prazo'];
                        $data[ $key ][ $freight->name ]['id'] = $freight->id;
                    }
                }
            }
            if($this->stores[$id]['amount_free']){
                $data[$id]['FREE']['val'] = 0;
                $data[$id]['FREE']['deadline'] = $data[$id]['PAC']['deadline'] + 2;
                $data[$id]['FREE']['id'] = 3;
                unset($data[$id]['PAC']);
            }
        }
        return $data;
    }

    // }
    public function all_free_freigth($store){
        $volume = 0;
        $weight = 0;
        if(isset($store['products'])){
            foreach($store['products'] as $id => $product){
                $product_data = Product::find($id);
                if(!$product_data->free_shipping){
                    return false;
                }else{
                    $volume += $product_data->width_cm * $product_data->length_cm * $product_data->height_cm * $product['qtd'];
                    $weight += $product_data->weight_gr * $product['qtd'];
                }
            }
            return ['volume' => $volume, 'weight' => $weight];
        }
        return false;
    }
}
