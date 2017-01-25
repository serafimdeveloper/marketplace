<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Store extends Model implements SluggableInterface
{
    protected $fillable = ['sallesman_id','name','type_people','document','fantasy_name','social_name','slug','brach_activity','about',
    'exchange_policy','freigth_policy','logo_file','rate','active'];

    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'name',
        'save_to' => 'slug'
    ];

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
