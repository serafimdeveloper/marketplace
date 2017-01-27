<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Salesman extends Model
{
    protected $fillable = ['moip','user_id','cpf','facebook','phone','whatsapp','cellphone','photo_document','proof_adress',
        'active'];
    protected $table = 'salesmans';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function store(){
        return $this->hasOne(Store::class);
    }
}
