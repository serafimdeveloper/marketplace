<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ObjectStatus extends Model {
    protected $fillable = ['code', 'status', 'date', 'local', 'encaminhado'];

    public function request(){
        return $this->belongsTo(Request::class);
    }
}
