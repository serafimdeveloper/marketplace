<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopValuation extends Model {
    protected $fillable = ['user_id', 'store_id', 'request_id', 'note_products', 'note_attendance', 'request_status', 'return_reason', 'comment', 'active'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function request(){
        return $this->belongsTo(Request::class);
    }
}
