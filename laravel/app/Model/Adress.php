<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adress extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id','store_id', 'name','zip_code','state','city','public_place','neighborhood','number','complements','master'];
    protected $dates = ['deleted_at'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }

    public function requests(){
        return $this->hasMany(Request::class);
    }



}
