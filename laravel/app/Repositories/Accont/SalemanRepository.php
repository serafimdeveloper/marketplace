<?php

namespace App\Repositories\Accont;
use App\Repositories\BaseRepository;
use App\Model\Salesman;

class SalemanRepository extends BaseRepository
{
    public function model(){
        return Salesman::class;
    }
}