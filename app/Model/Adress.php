<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    protected $fillable = ['user_id','zip_code','state','city','public_place','neighborhood','number','complements','name', 'master'];
    
    public $timestamps = false;

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

}
