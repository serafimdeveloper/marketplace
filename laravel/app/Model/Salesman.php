<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salesman extends Model
{
    use SoftDeletes;
    protected $fillable = ['moip','user_id','cpf','facebook','phone','whatsapp','cellphone','photo_document', 'proof_adress', 'active'];
    protected $table = 'salesmans';
    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function store(){
        return $this->hasOne(Store::class);
    }

    public function connect(){
        return $this->hasOne(ConnectSallesman::class);
    }
}
