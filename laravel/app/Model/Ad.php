<?php

namespace App;

use App\Model\Store;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model{

    public $fillable = ['description', 'date_start','date_end'];

    public function store(){
        return $this->belongsTo(Store::class);
    }
}
