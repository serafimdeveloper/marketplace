<?php

namespace App\Model;

use App\Ad;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $fillable = ['salesman_id','name','type_salesman','cnpj','fantasy_name','social_name','slug','brach_activity'
        ,'about','exchange_policy','freight_policy','logo_file','rate','active','blocked'];
    protected $dates = ['deleted_at'];


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

    public function owner_sender(){
        return $this->morphOne(Message::class,'sender' );
    }

    public function owner_recipient(){
        return $this->morphOne(Message::class,'recipient' );
    }

    public function salesman(){
        return $this->belongsTo(Salesman::class);
    }

    public function adress(){
        return $this->hasOne(Adress::class);
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

    public function scopeSearch($query, $name, $with) {
        return $query->where('name', 'LIKE', '%'.$name.'%')->with($with);
    }

    public function ad(){
        return $this->hasOne(Ad::class);
    }
}
