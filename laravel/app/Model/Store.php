<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model {
    use Sluggable, SoftDeletes;
    protected $fillable = ['seller_id', 'name', 'type_seller', 'cnpj', 'fantasy_name', 'social_name', 'slug', 'brach_activity', 'about', 'exchange_policy', 'freight_policy', 'logo_file', 'rate', 'active', 'blocked'];
    protected $dates = ['deleted_at'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(){
        return ['slug' => ['source' => 'name']];
    }

    public function owner_sender(){
        return $this->morphOne(Message::class, 'sender');
    }

    public function owner_recipient(){
        return $this->morphOne(Message::class, 'recipient');
    }

    public function seller(){
        return $this->belongsTo(Seller::class);
    }

    public function address(){
        return $this->hasOne(Address::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function requests(){
        return $this->hasMany(Request::class);
    }

    public function shop_valuations(){
        return $this->hasMany(ShopValuation::class);
    }

    public function scopeSearch($query, $name, $with){
        return $query->where('name', 'LIKE', '%' . $name . '%')->with($with);
    }

    public function ad(){
        return $this->hasOne(Ad::class);
    }
}
