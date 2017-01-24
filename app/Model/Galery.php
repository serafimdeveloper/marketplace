<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Galery extends Model
{
    protected $fillable = ['product_id','image'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
