<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Moip extends Model
{
    protected $fillable = ['request_id', 'token', 'status', 'codeMoip', 'codeReturn', 'url'];

    public function request(){
        return $this->belongsTo(Request::class);
    }
}
