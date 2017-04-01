<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','confirm_token','last_name','cpf','document','birth','genre','phone','type_user',
        'last_access','active'
    ];
    protected $dates = ['deleted_at','last_access'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function addresses(){
        return $this->hasMany(Adress::class);
    }

    public function requests(){
        return $this->hasMany(Request::class);
    }

    public function salesman(){
        return $this->hasOne(Salesman::class);
    }

    public function admin(){
        return $this->hasOne(Admin::class);
    }

    public function recipient(){
        return $this->hasOne(User::class);
    }

    public function sender(){
        return $this->hasOne(User::class);
    }

    public function visitproducts(){
        return $this->hasMany(VisitProduct::class);
    }

    public function shopvaluations(){
        return $this->hasMany(ShopValuation::class);
    }

    public function owner_sender(){
        return $this->morphOne(Message::class,'sender' );
    }

    public function owner_recipient(){
        return $this->morphOne(Message::class,'recipient' );
    }

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }

    public function cartsession(){
        return $this->hasOne(CartSession::class);
    }

    public function scopeSearch($query, $name, $with) {
        return $query->where('name', 'LIKE', '%'.$name.'%')->orWhere('email','LIKE','%'.$name.'%')->with($with);
    }
}
