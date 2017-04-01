<?php

namespace App\Repositories\Accont;
use App\Repositories\BaseRepository;
use App\Model\Salesman;

class SalesmanRepository extends BaseRepository
{
    public function model(){
        return Salesman::class;
    }
}