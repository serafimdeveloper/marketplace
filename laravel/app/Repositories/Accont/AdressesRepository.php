<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 24/01/2017
 * Time: 21:25
 */

namespace App\Repositories\Accont;


use App\Repositories\BaseRepository;
use App\Model\Address;

class AdressesRepository extends BaseRepository
{
    public function model()
    {
        return Address::class;
    }
}