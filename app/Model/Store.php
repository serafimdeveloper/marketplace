<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Store extends Model
{
    protected $fillable = ['salesman_id','name','type_people','cpf','cnpj','fantasy_name','social_name','slug','brach_activity'
        ,'about','exchange_policy','freigth_policy','logo_file','rate','active'];

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

    public function sallesman(){
        return $this->belongsTo(Sallesman::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function requests(){
        return $this->hasMany(Request::class);
    }

    public function shopvaluation(){
        return $this->hasMany(ShopValuation::class);
    }

    public function scopeSearch($query, $name) {
        return $query->where('name', 'LIKE', "%$name%");
    }
}
