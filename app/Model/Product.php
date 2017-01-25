<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Product extends Model implements SluggableInterface
{
    protected  $fillable = ['store_id','category_id','subcategory_id','name','price','price_out_discount','deadline',
        'free_shippping','minimum_stock','delivery_time','details','length_cm','width_cm','height_cm','weight_gr',
        'diameter_cm','active','featured'];

    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'name',
        'save_to' => 'slug'
    ];

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
