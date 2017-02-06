<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    protected $fillable = ['user_id','name','zip_code','state','city','public_place','neighborhood','number','complements','master'];
    
    public $timestamps = false;

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function requests(){
        return $this->hasMany(Request::class);
    }

    public function store(){
        return $this->hasOne(Store::class);
    }

}
