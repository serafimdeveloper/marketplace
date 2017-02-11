<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Product extends Model
{

    protected  $fillable = ['store_id','category_id','name','price','price_out_discount','deadline',
        'free_shipping','minimum_stock','details','length_cm','width_cm','height_cm','weight_gr','slug',
        'diameter_cm','active','featured'];

    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(){
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    /*public function subcategory(){
        return $this->belongsTo(SubCategory::class);
    }

    public function requests(){
        return $this->belongsToMany(Request::class);
    }*/


    public function requests(){
        return $this->belongsToMany(Request::class)->withPivot(['quantity', 'unit_price', 'amount']);
    }

    public function movementstocks(){
        return $this->hasMany(MovementStock::class);
    }

    public function galeries(){
        return $this->hasMany(Galery::class);
    }
}
