<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 24/01/2017
 * Time: 21:25
 */

namespace App\Repositories\Account;


use App\Model\ConnectSeller;
use App\Repositories\BaseRepository;

class ConnectSallesmanRepository extends BaseRepository
{
    public function model()
    {
        return ConnectSeller::class;
    }
}