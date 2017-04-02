<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use SoftDeletes;
    protected $fillable =['user_id','adress_id','store_id','key','freight_id','deadline','settlement_date','cancellation_date',
        'send_date','payment_id','number_installments','tracking_code','freight_price','payment_reference','note',
        'request_status_id', 'phone','amount','visualized'];

    protected  $dates = ['create_at','update_at','deleted_at','cancellation_date','send_date','settlement_date'];

    protected $casts = ['number_installments'=>'integer','freight_price'=>'double','amount'=>'double'];



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

    public function moip(){
        return $this->hasOne(Moip::class);
    }

    public function scopeSearch($query, $name, $with) {
        return $query->where('key', 'LIKE', '%'.$name.'%')->with($with);
    }
}
