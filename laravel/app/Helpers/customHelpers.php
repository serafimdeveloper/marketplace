<?php
use App\Model\Ad;
use App\Model\CountOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Correios;

if(!function_exists('track_object')){
    function track_object($code, $id){
        $local = false;
        $order = \App\Model\Request::find($id);
        $st = ($order->tracking_code == $code ? 4 : 3);
        if($order->requeststatus->id >= $st){
            $tracking = Correios::rastrear($code);
            if($tracking){
                $local['message'] = false;
                $local['current'] = current($tracking);
                $local['posted'] = end($tracking);
                if($local['current']['status'] == 'Entrega Efetuada'){
                    $order->fill(['request_status_id' => 5])->save();
                }
            }else{
                $local['message'] = 'Objeto não encontrado ou não atualizado pelo correio';
            }
        }
        return $local;
    }
}

if(!function_exists('banner_ads')){
    function banner_ads(){
        $date = date('Y-m-d');
        $ads = Ad::whereDate('date_start', '<=' , $date)
            ->whereDate('date_end', '>=' , $date)
            ->get();
        $adData = [];
        foreach($ads as $ad){
            $adData[] = [
                'image' => url('/imagem/loja/' . $ad->store->logo_file . '?w=100&h=100&fit=crop'),
                'name' => $ad->store->name,
                'description' => $ad->description,
                'url' => url('/' . $ad->store->slug)
            ];
        }
        return $adData;
    }
}

if(!function_exists('image_type')){
    function image_type($image){
        $img = explode(".", $image);
        return end($img);
    }
}

if(!function_exists('discont_percent')){
    function discont_percent($price, $discont){
        $r = ($discont * 100) / $price;
        return (round(100 - $r, 0) < 10 ? '0' . round(100 - $r, 0) : round(100 - $r, 0));
    }
}

if(!function_exists('notification_sales')){
    function notification_sales($visualized)
    {
        if(Gate::allows('vendedor')){
            if($store = Auth::user()->salesman->store){
                return count(DB::table('requests')->where('visualized_store', $visualized)->where('store_id',$store->id)->get());
            }
        }
        return 0;
    }
}

if(!function_exists('notification_request')){
    function notification_request($visualized)
    {
        if($user = Auth::user()){
            return count(DB::table('requests')->where('visualized_user', $visualized)->where('user_id',$user->id)->get());
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

if(!function_exists('is_favorite')){
    function is_favorite(array $store, $id, $product_id){
        if(isset($store[$id])){
            foreach($store[$id]['products'] as $product){
                if($product->id === $product_id){
                    return true;
                }
            }
        }
        return false;
    }
}

if(!function_exists('real')){
    function real($value)
    {
        return 'R$ ' . number_format($value, 2, ',', '.');
    }
}

if(!function_exists('amount_cart')){
    function amount_cart(){
        if(Session::has('cart') || isset(Auth::user()->cartsession->stores)){
            $cart_service = new \App\Services\CartServices();
            $cartDB = isset(Auth::user()->cartsession) ? Auth::user()->cartsession : null;
            $cartModelDB = ($cartDB) ? $cart_service->dbCart(json_decode($cartDB->address, true), json_decode($cartDB->stores, true))->getCart() : null;
            $oldCart = (Session::has('cart')) ?  Session::get('cart') : $cartModelDB;
            $cart = $cart_service->setCart($oldCart)->check_cart()->getCart();
            return real($cart->amount);
        }
        return real(0);
    }
}

if(!function_exists('generate_key')){
    function generate_key(){
        $count = CountOrder::first();
        $value = $count->count + 1;
        $key = substr(date('M'), 0, 1) .  date('Y') . date('d') . $value;
        $count->update(['count' => $value]);
        return $key;
    }
}

if(!function_exists('get_categories')){
    function get_categories($principal = null){
        $categories = DB::table('categories')->whereNull('category_id')->where('active','=',1);
        if(isset($principal)){
            $categories = $categories->where('menu','=',1)->limit(10);
        }else{
            $categories = $categories->limit(25);
        }
        return $categories->get();
    }
}

if(!function_exists('send_mail')){
    function send_mail($template, $data, $subject){
        Mail::send( $template, $data, function($mail) use($data, $subject) {
            $mail->to($data['email'])
                ->from('sac@popmartin.com.br')
                ->subject($subject);
        });
    }
}
