<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected  $fillable = ['store_id','category_id','name','price','price_out_discount','deadline',
        'free_shipping','minimum_stock','details','length_cm','width_cm','height_cm','weight_gr','slug',
        'active','featured','deleted_at'];

    use Sluggable, SoftDeletes;

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

    public function requests(){
        return $this->belongsToMany(Request::class)->withPivot(['quantity', 'unit_price', 'amount']);
    }

    public function movement_stocks(){
        return $this->hasMany(MovementStock::class);
    }

    public function galleries(){
        return $this->hasMany(Gallery::class);
    }

    public function visit_product(){
        return $this->hasMany(VisitProduct::class);
    }

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }

    public function scopeSearch($query, $name, $with) {
        return $query->where('products.name', 'LIKE', '%'.$name.'%')->with($with);
    }
}
