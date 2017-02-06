<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VisitProduct extends Model
{
    protected $fillable = ['user_id','product_id','count'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
