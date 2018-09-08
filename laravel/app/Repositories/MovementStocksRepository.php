<?php
namespace App\Repositories;

use App\Model\MovementStock;

class MovementStocksRepository extends BaseRepository
{
    public function model(){
        return MovementStock::class;
    }

}