<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use SoftDeletes;

    protected $fillable =['user_id','store_id','key','freight_id','deadline','settlement_date','cancellation_date',
        'send_date', 'tracking_code','freight_price','note', 'request_status_id', 'phone','amount','visualized_store',
        'visualized_user', 'address_receiver','address_sender'];

    protected $dates = ['create_at','update_at','deleted_at','cancellation_date','send_date','settlement_date'];

    protected $casts = ['freight_price'=>'double','amount'=>'double'];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function type_freight(){
        return $this->belongsTo(TypeFreight::class);
    }

    public function request_status(){
        return $this->belongsTo(RequestStatus::class,'request_status_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot(['quantity', 'unit_price', 'amount'])->withTrashed();
    }

    public function payment() {
        return $this->hasOne(Payment::class);
    }

    public function store(){
        return $this->belongsTo(Store::class)->withTrashed();
    }

    public function shop_valuation(){
        return $this->hasOne(ShopValuation::class);
    }

    public function movement_stocks(){
        return $this->hasMany(MovementStock::class);
    }

    public function moip(){
        return $this->hasOne(Moip::class);
    }

    public function scopeSearch($query, $name, $with) {
        return $query->where('key', 'LIKE', '%'.$name.'%')->with($with);
    }

    public function object() {
        return $this->hasOne(ObjectStatus::class);
    }
}
