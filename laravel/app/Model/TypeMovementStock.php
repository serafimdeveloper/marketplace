<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class TypeMovementStock extends Model
{
    protected  $fillable = ['name','description','type','slug','active'];

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


    public function movementstocks(){
        return $this->hasMany(MovementStock::class);
    }
}
