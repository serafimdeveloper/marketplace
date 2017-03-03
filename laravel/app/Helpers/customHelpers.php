<?php
use App\Model\Freight;
use App\Model\Product;
use App\Model\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

if(!function_exists('notification_sales')){
    function notification_sales($visualized)
    {
        if(Gate::allows('vendedor')){
            if($store = Auth::user()->salesman->store){
                return count(DB::table('requests')->where('visualized', '=', $visualized)->where('store_id', '=', $store->id)->get());
            }
        }
        return 0;
    }
}
if(!function_exists('notification_message_client')){
    function notification_message_client($visualized = 'received')
    {
        if($user = Auth::user()){
            $messages = DB::table('messages')->where('status', '=', $visualized)->where('recipient_id', '=', $user->id)->where('recipient_type', '=', get_class($user))->where('desactive', '=', 0)->get();
            return count($messages);
        }
        return 0;
    }
}
if(!function_exists('notification_message_salesman')){
    function notification_message_salesman($visualized = 'received')
    {
        if($store = Auth::user()->salesman->store){
            $messages = DB::table('messages')->where('status', '=', $visualized)->where('recipient_id', '=', $store->id)->where('recipient_type', '=', get_class($store))->where('desactive', '=', 0)->get();
            return count($messages);
        }
        return 0;
    }
}
if(!function_exists('amount_products')){
    function amount_products($products)
    {
        $amount = 0;
        foreach($products as $product){
            $amount += $product->pivot->amount;
        }
        return $amount;
    }
}
if(!function_exists('amount_products_final')){
    function amount_products_final($products, $freight)
    {
        $amount = amount_products($products);
        $amount_final = (double)$amount + $freight;
        return $amount_final;
    }
}
if(!function_exists('real')){
    function real($value)
    {
        return 'R$ ' . number_format($value, 2, ',', '.');
    }
}
if(!function_exists('buscar_address')){
    function buscar_address($adress)
    {

    }
}
if(!function_exists('calculate_freight')){
    function calculate_freight($cep)
    {
        $data = array();
        if ($ses = Session::get('cart')) {
            $volume = 0;
            $weight = 0;
            /** Variávei de dados a serem passados para o cáculo de frete */
            $df['formato'] = 'caixa';
            $df['diametro'] = 0;
            $df['cep_destino'] = preg_replace("/-/", '', $cep);;
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
                foreach ($ses->stores as $id => $products) {
                    $volume = 0;
                    $weight = 0;
                    $freights = Freight::where('code', '!=', null)->get();
                    foreach ($freights as $freight) {
                    /** definir tipo para minusculo para comparar com biblioteca vendor de cálculo de frete */
                    $df['tipo'] = trim(strtolower($freight->name));

                    /**
                     * Pegar cada produto para somar seu volume e obter peso total
                     * @var  $product_id
                     * @var  $product
                     */
                    foreach ($products['products'] as $product_id => $product) {
                        $product_data = Product::find($product_id);
                        /** Verifica se algum produto esta marcado como frete grátis, então zera seu valor */
                        if (!$product_data->free_shipping || $freight->code != '41106') {
                            $volume += $product_data->width_cm * $product_data->length_cm * $product_data->height_cm * $product['qtd'];
                            $weight += $product_data->weight_gr * $product['qtd'];
                        }
                    }
                    /** @var  $volume - Arredondar para cima o valor do volume */
                    $volume = ceil($volume);
                    /** @var  $weight - transformar para Kilos */
                    $weight = $weight / 1000;
                    /** @var  $loop - Inicialização de loop caso para divição de pacotes caso as regras de cálculo de frete não se aplique */
                    $loop = 1;
                    /** @var  $r3 - raíz Cúbica do volume total */
                    $r3 = ceil(pow($volume, 1 / 3));
                    /** Enquanto a soma da altura, largura e comprimento for maior que 200, divide o pacote em 2 */
                    while ($r3 * 3 >= 200) {
                        $r3 = $r3 / 2;
                        $weight = $weight / 2;
                        $loop++;
                    }
                    $df['cep_origem'] = preg_replace("/-/", '', Store::find($id)->adress['zip_code']);
                    $df['comprimento'] = $r3;
                    $df['altura'] = $r3;
                    $df['largura'] = $r3;
                    $df['peso'] = $weight;
                    /** @var  $i - Calcula o frete separadamente de acordo com a separação de pacotes */
                    for ($i = 0; $i < $loop; $i++) {
                        /** Armazena cada cálculo */
                        $return[$id][$freight->name][] = Correios::frete($df);
                    }

                    /**
                     * Monta o array com informações a serem retornadas separadas pelo Id de cada loja
                     * @var  $key
                     * @var  $value
                     */
                    foreach ($return as $key => $value) {
                        $data[$key][$freight->name]['val'] = 0;
                        for ($i = 0; $i < count($value[$freight->name]); $i++) {
                            $data[$key][$freight->name]['val'] += $value[$freight->name][$i]['valor'];
                            $data[$key][$freight->name]['deadline'] = $value[$freight->name][$i]['prazo'];
                        }
                    }
                }
            }
            // dd($data);
            return $data;
        }
    }
}

