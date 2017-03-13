<?php
use App\Model\CountOrder;
use App\Model\Freight;
use App\Model\Product;
use App\Model\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

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

if(!function_exists('is_favorite')){
    function is_favorite(array $store, $id, $product){
        if(isset($store[$id])){
            $collection = new \Illuminate\Support\Collection( $store[$id]['products']);
            if($collection->each(function($item, $key) use($product){
                if($item->id === $product->id){
                    return true;
                }
            })){
                return true;
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

if(!function_exists('generate_key')){
    function generate_key(){
        $count = CountOrder::first();
        $value = $count->count + 1;
        $key = substr(date('M'), 0, 1) .  date('Y') . date('d') . $value;
        $count->update(['count' => $value]);
        return $key;
    }
}

if(!function_exists('get_categories()')){
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
