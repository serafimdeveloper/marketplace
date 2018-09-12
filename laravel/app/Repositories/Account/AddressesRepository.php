<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 24/01/2017
 * Time: 21:25
 */

namespace App\Repositories\Account;


use App\Repositories\BaseRepository;
use App\Model\Address;

class AddressesRepository extends BaseRepository
{
    public function model()
    {
        return Address::class;
    }
}