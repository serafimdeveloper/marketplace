<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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
            $messages = DB::table('messages')->where('status', '=', $visualized)->where('recipient_id', '=', $user->id)->where('recipient_type', '=', get_class($user))->get();
            return count($messages);
        }
        return 0;
    }
}

if(!function_exists('notification_message_salesman')){
    function notification_message_salesman($visualized = 'received')
    {
        if($store = Auth::user()->salesman->store){
            $messages = DB::table('messages')->where('status', '=', $visualized)->where('recipient_id', '=', $store->id)->where('recipient_type', '=', get_class($store))->get();
            return count($messages);
        }
        return 0;
    }
}

if(!function_exists('amount_products')){
    function amount_products($products){
        $amount = 0;
        foreach($products as $product){
            $amount+= $product->pivot->amount;
        }
        return $amount;
    }
}

if(!function_exists('amount_products_final')){
    function amount_products_final($products,$freight){
        $amount = amount_products($products);
        $amount_final = (double) $amount + $freight;
        return $amount_final;
    }
}


