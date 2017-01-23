<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{

    protected $fillable=['user_id','settlement_date','send_date','payment_id','number_installments','freight_amount','payment_reference','note'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
