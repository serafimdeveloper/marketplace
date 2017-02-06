<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['name','active'];

    public function requests(){
        return $this->hasMany(Request::class);
    }
}
