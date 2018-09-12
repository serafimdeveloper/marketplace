<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 10/02/2017
 * Time: 14:48
 */

namespace App\Repositories\Account;

use App\Model\TypeMovementStock;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class TypeMovementsStocksRepository extends BaseRepository
{
    /**
     * @return Model
     */
    public function model(){
        return TypeMovementStock::class;
    }

}