<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RequestStatus extends Model
{
    protected $fillable = ['description','active'];

    public function requests(){
        return $this->hasMany(Request::class);
    }
}
