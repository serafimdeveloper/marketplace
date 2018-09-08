<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TypeFreight extends Model
{
    protected $fillable = ['name','code','active'];

    public function requests(){
        return $this->hasMany(Request::class);
    }
}
