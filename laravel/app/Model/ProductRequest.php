<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    protected $fillable = ['request_id', 'product_id', 'quantity', 'amount'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function request()
    {
        return $this->belongsTo(Request::class);
    }
}
