<?php
/**
 * Created by PhpStorm.
 * User: douglas
 * Date: 07/09/18
 * Time: 17:21
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['request_id', 'type_payment_id', 'number_installments', 'commission_amount',
        'rate_moip', 'payment_reference', 'payment_institution', 'status'];

    public function request() {
        return $this->belongsTo(Request::class);
    }

    public function type_payment() {
        return $this->belongsTo(Payment::class);
    }

}