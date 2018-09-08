<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
    protected $fillable = ['message_id', 'reason', 'read'];

    public function message(){
        return $this->belongsTo(Message::class);
    }
}
