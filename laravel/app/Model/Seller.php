<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends Model {
    use SoftDeletes;

    protected $fillable = ['moip', 'user_id', 'cpf', 'facebook', 'phone', 'whatsapp', 'cellphone', 'photo_document', 'proof_address', 'comission', 'read', 'active'];
    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function store(){
        return $this->hasOne(Store::class);
    }

    public function connect(){
        return $this->hasOne(ConnectSeller::class);
    }
}
