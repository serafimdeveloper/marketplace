<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ConnectSeller extends Model{

    protected $fillable = ['seller_id', 'accessToken', 'access_token', 'refreshToken', 'refresh_token', 'scope', 'moipAccount_id', 'expires_in'];

    public function seller()
    {
    	return $this->belongsTo(Seller::class);
    }

}
