<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    protected $fillable = ['name','order','category_id','slug','menu','active'];

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

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function subcategories(){
        return $this->hasMany($this);
    }

    public function category(){
        return $this->belongsTo($this,'category_id');
    }
}
