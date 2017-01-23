<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['sallesman_id','name','type_people','document','fantasy_name','social_name','slug','brach_activity','about',
    'exchange_policy','freigth_policy','logo_file','rate','active'];

    public function sallesman(){
        return $this->belongsTo(Sallesman::class);
    }
}
