<?php

namespace App\Model;

use App\Model\Simulation\SubCategory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','order','category_id', 'slug', 'menu','active'];

    public function products(){
        return $this->hasMany(Product::class);

    }

    public function subcategories(){
        return $this->hasMany($this);
    }
}
