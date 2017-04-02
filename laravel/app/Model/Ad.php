<?php

namespace App\Model;

use App\Model\Store;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model{

    public $fillable = ['description','store_id', 'date_start','date_end'];

    public function store(){
        return $this->belongsTo(Store::class);
    }
}
