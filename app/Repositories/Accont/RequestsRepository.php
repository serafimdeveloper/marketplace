<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 24/01/2017
 * Time: 22:12
 */

namespace App\Repositories\Accont;

use App\Repositories\BaseRepository;
use App\Model\Request;

class RequestsRepository extends BaseRepository
{

    public function model()
    {
        return Request::class;
    }
}