<?php
/**
 * Created by PhpStorm.
 * User: douglas
 * Date: 31/08/18
 * Time: 17:20
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TypePayment extends Model
{
    protected $fillable = ['name','active'];
}