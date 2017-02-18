<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 17/02/2017
 * Time: 02:57
 */

namespace App\Repositories\Accont;


use App\Model\ShopValuation;
use App\Repositories\BaseRepository;

class ShopValuationsRepository extends BaseRepository
{
    public function model(){
        return ShopValuation::class;
    }

}