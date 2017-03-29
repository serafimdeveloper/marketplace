<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ConnectSallesman extends Model{

    protected $table = 'connect_sallesmans';
    protected $fillable = ['salesman_id', 'accessToken', 'access_token', 'refreshToken', 'refresh_token', 'scope', 'moipAccount_id', 'expires_in'];

    public function salesman()
    {
    	return $this->belongsTo(Salesman::class);
    }

}
