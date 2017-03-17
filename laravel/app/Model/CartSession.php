<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CartSession extends Model
{
    protected $fillable =['user_id','address','stores'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
