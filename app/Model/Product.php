<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected  $fillable = ['store_id','category_id','subcategory_id','name','price','price_out_discount','deadline',
        'free_shippping','minimum_stock','delivery_time','details','length_cm','width_cm','height_cm','weight_gr',
        'diameter_cm','active','featured'];

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function subcategory(){
        return $this->belongsTo(SubCategory::class);
    }

    public function requests(){
        return $this->belongsToMany(Request::class);
    }

    public function movementstocks(){
        return $this->hasMany(MovementStock::class);
    }
}
