<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','confirm_token','last_name','document','birth','genre'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function adresses(){
        return $this->hasMany(Adress::class);
    }

    public function requests(){
        return $this->hasMany(Request::class);
    }

    public function sallesman(){
        return $this->hasOne(Sallesman::class);
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
}
