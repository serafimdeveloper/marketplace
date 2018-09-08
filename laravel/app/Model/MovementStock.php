<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MovementStock extends Model
{
    protected $fillable = ['product_id','request_id','count','reason','type_movement_stock_id'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function request(){
        return $this->belongsTo(Request::class);
    }

    public function type_movement_stock(){
        return $this->belongsTo(TypeMovementStock::class);
    }
}

