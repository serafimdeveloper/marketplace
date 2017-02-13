<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

if(!function_exists('notification_sales')){
    function notification_sales($visualized){
        if(Gate::allows('vendedor')){
            if($store = Auth::user()->salesman->store){
                return count(DB::table('requests')->where('visualized','=',$visualized)->where('store_id','=',$store->id)->get());
            }
        }
        return 0;
    }
}
