<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MessageType extends Model
{
    protected $fillable = ['description','active'];

    public function messages(){
        return $this->hasMany(Message::class);
    }
}
