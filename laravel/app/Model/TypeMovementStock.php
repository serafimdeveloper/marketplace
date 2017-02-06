<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TypeMovementStock extends Model
{
    protected  $fillable = ['name','description','active'];

    public function movementstocks(){
        return $this->hasMany(MovementStock::class);
    }
}
