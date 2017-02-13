<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['sender_id','sender_type','recipient_id','recipient_type','message_type_id','request_id','product_id','message_id','title',
        'content','status'];

    public function sender(){
        return $this->morphTo();
    }

    public function recipient(){
        return $this->morphTo();
    }

    public function message_type(){
        return $this->belongsTo(MessageType::class,'message_type_id');
    }

    public function request(){
        return $this->belongsTo(Request::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function message(){
        return $this->hasMany($this);
    }
}
