<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = ['user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function owner_sender(){
        return $this->morphOne(Message::class,'sender' );
    }

    public function owner_recipient(){
        return $this->morphOne(Message::class,'recipient' );
    }
}
