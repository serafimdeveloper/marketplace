<?php
use App\Model\Ad;
use App\Model\CountOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Cagartner\CorreiosConsulta\Facade as Correios;

if(!function_exists('track_object')){
    function track_object($code, $id){
        $local = false;
        $order = \App\Model\Request::find($id);
        $st = ($order->tracking_code == $code ? 4 : 3);
        if($order->request_status->id >= $st){
            $tracking = Correios::rastrear($code);
//            dd($tracking);
            if($tracking){
                $local['message'] = false;
                $local['current'] = current($tracking);
                $local['posted'] = end($tracking);
                if($order->object){
                    $order->object()->update(['code' => $code, 'status' => $local['current']['status'], 'date' => $local['current']['data'], 'local' => $local['current']['local'], 'encaminhado' => isset($local['current']['encaminhado']) ? $local['current']['encaminhado'] : 'Entrega Efetuada']);
                }else{
                    $order->object()->create(['code' => $code, 'status' => $local['current']['status'], 'date' => $local['current']['data'], 'local' => $local['current']['local'], 'encaminhado' => isset($local['current']['encaminhado']) ? $local['current']['encaminhado'] : 'Entrega Efetuada']);
                }
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
        $date = Carbon::now();
        $ads = Ad::whereDate('date_start', '<=', $date)->whereDate('date_end', '>=', $date)->get();
        $adData = [];
        foreach($ads as $ad){
            $adData[] = ['image' => url('/imagem/loja/' . $ad->store->logo_file . '?w=100&h=100&fit=crop'), 'name' => $ad->store->name, 'description' => $ad->description, 'url' => url('/' . $ad->store->slug)];
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
    function notification_sales($visualized){
        if(Gate::allows('vendedor')){
            if(Auth::user()->seller){
                if($store = Auth::user()->seller->store){
                    return count(DB::table('requests')->where('visualized_store', $visualized)->where('store_id', $store->id)->get());
                }
            }
        }

        return 0;
    }
}
if(!function_exists('notification_request')){
    function notification_request($visualized){
        if($user = Auth::user()){
            return count(DB::table('requests')->where('visualized_user', $visualized)->where('user_id', $user->id)->get());
        }

        return 0;
    }
}
if(!function_exists('notification_message_client')){
    function notification_message_client($visualized = 'received'){
        if($user = Auth::user()){
            $messages = DB::table('messages')->where('status', '=', $visualized)->where('recipient_id', '=', $user->id)->where('recipient_type', '=', get_class($user))->where('disabled', '=', 0)->get();

            return count($messages);
        }

        return 0;
    }
}
if(!function_exists('notification_message_seller')){
    function notification_message_seller($visualized = 'received'){
        if(Auth::user()->seller){
            if($store = Auth::user()->seller->store){
                $messages = DB::table('messages')->where('status', '=', $visualized)->where('recipient_id', '=', $store->id)->where('recipient_type', '=', get_class($store))->where('disabled', '=', 0)->get();

                return count($messages);
            }
        }

        return 0;
    }
}
if(!function_exists('notification_notify_admin')){
    function notification_notify_admin($read = 0){
        if($admin = Auth::user()->admin){
            $notify = DB::table('notifications')->where('read', '=', 0)->get();
            return count($notify);
        }

        return 0;
    }
}

if(!function_exists('notification_new_sallesman')){
    function notification_new_sallesman($read = 0){
        if($admin = Auth::user()->admin){
            $notify = DB::table('sellers')->where('read', '=', 0)->get();
            return count($notify);
        }

        return 0;
    }
}

if(!function_exists('amount_products')){
    function amount_products($products){
        $amount = 0;
        foreach($products as $product){
            $amount += $product->pivot->amount;
        }

        return $amount;
    }
}
if(!function_exists('amount_products_final')){
    function amount_products_final($products, $freight){
        $amount = amount_products($products);
        $amount_final = (double)$amount + $freight;

        return $amount_final;
    }
}
if(!function_exists('is_favorite')){
    function is_favorite(array $store, $id, $product_id){
        if(isset($store[ $id ])){
            foreach($store[ $id ]['products'] as $product){
                if($product->id === $product_id){
                    return true;
                }
            }
        }

        return false;
    }
}
if(!function_exists('real')){
    function real($value){
        return 'R$ ' . number_format($value, 2, ',', '.');
    }
}

if(!function_exists('limit_text')){
    function limit_text($text, $limit){
        if(strlen($text) > $limit){
            return substr($text,0,$limit-3).'...';
        }
        return $text;
    }
}
if(!function_exists('amount_cart')){
    function amount_cart(){
        if(Session::has('cart') || isset(Auth::user()->cartsession->stores)){
            $cart_service = new \App\Services\CartServices();
            $cartDB = isset(Auth::user()->cartsession) ? Auth::user()->cartsession : null;
            $cartModelDB = ($cartDB) ? $cart_service->dbCart(json_decode($cartDB->address, true), json_decode($cartDB->stores, true))->getCart() : null;
            $oldCart = (Session::has('cart')) ? Session::get('cart') : $cartModelDB;
            $cart = $cart_service->setCart($oldCart)->check_cart()->getCart();

            return real($cart->amount);
        }

        return real(0);
    }
}

if(!function_exists('amount_cart_value')){
    function amount_cart_value(){
        $amount = 0.00;
        if(Session::has('cart') || isset(Auth::user()->cartsession->stores)){
            $cart_service = new \App\Services\CartServices();
            $cartDB = isset(Auth::user()->cartsession) ? Auth::user()->cartsession : null;
            $cartModelDB = ($cartDB) ? $cart_service->dbCart(json_decode($cartDB->address, true), json_decode($cartDB->stores, true))->getCart() : null;
            $oldCart = (Session::has('cart')) ? Session::get('cart') : $cartModelDB;
            $cart_service->setCart($oldCart)->getCart();
            if($cartDB){
                if($cartDB->stores){
                    $jsonCartDB = json_decode($cartDB->stores);
//                    dd($jsonCartDB);
                    foreach($jsonCartDB as $store){
                        $amount += $store->amount;
                    }
                }

            }
        }
        return real($amount);
    }
}

if(!function_exists('generate_key')){
    function generate_key(){
        $count = CountOrder::first();
        $value = $count->count + 1;
        $key = substr(date('M'), 0, 1) . date('Y') . date('d') . $value;
        $count->update(['count' => $value]);

        return $key;
    }
}
if(!function_exists('get_categories')){
    function get_categories($principal = null){
        $categories = DB::table('categories')->whereNull('category_id')->where('active', '=', 1);
        if(isset($principal)){
            $categories = $categories->where('menu', '=', 1)->limit(10);
        }else{
            $categories = $categories->limit(25);
        }

        return $categories->get();
    }
}
if(!function_exists('send_mail')){
    function send_mail($template, $data, $subject){
        Mail::send($template, $data, function($mail) use ($data, $subject){
            $mail->to($data['email'])->from('sac@popmartin.com.br')->subject($subject);
        });
    }
}
if(!function_exists('send_mail_type')){
    function send_mail_type($type, $template, $data, $subject){
        $data['email'] = ($type === 'client') ? $data['user']->email : $data['store']->seller->user->email;
        $data['name'] = ($type === 'client') ? $data['user']->name : $data['store']->seller->user->name;
        send_mail($template, $data, $subject);
    }
}

if(!function_exists('clear_special_chars')){
    function clear_special_chars($string, $separator = null){
        $separator = ($separator ? $separator : '-');

        $Formato = array();
        $Formato['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        $Formato['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

        $Info = strtr(utf8_decode($string), utf8_decode($Formato['a']), $Formato['b']);
        $Info = strip_tags(trim($Info));
        $Info = strtolower(utf8_encode($Info));

        $Info = str_replace(' ', $separator, $Info);
        $Info = str_replace(array(str_repeat($separator, 5), str_repeat($separator, 4), str_repeat($separator, 3), str_repeat($separator, 2)), $separator, $Info);

        return $Info;
    }
}