<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CountOrder extends Model
{
    protected $fillable = ['count'];
    public $timestamps = false;
}
