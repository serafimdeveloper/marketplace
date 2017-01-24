<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sallesman extends Model
{
    protected $fillable = ['moip','user_id','cpf','facebook','whatsapp','cellphone','photo_document','proof_adress',
        'active'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function store(){
        return $this->hasOne(Store::class);
    }
}
