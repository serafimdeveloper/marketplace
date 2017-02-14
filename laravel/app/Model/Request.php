<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable =['user_id','adress_id','freight_id','settlement_date','cancellation_date','send_date','payment_id',
        'number_installments','tracking_code','freight_price','payment_reference','note','request_status_id','amount'];

    protected  $dates = ['create_at','update_at','cancellation_date','send_date','settlement_date'];

    protected $casts = ['settlement_date' => 'date','cancellation_date'=>'datetime','send_date'=>'datetime',
        'number_installments'=>'integer','freight_price'=>'double','amount'=>'double'];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function adress(){
        return $this->belongsTo(Adress::class);
    }

    public function freight(){
        return $this->belongsTo(Freight::class);
    }

    public function payment(){
        return $this->belongsTo(Payment::class);
    }

    public function requeststatus(){
        return $this->belongsTo(RequestStatus::class,'request_status_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot(['quantity', 'unit_price', 'amount']);
    }

    public function store(){
        return $this->belongsTo(Store::class);
    }


    public function shopvaluation(){
        return $this->hasOne(ShopValuation::class);
    }

    public function movementstocks(){
        return $this->hasMany(MovementStock::class);
    }
}
