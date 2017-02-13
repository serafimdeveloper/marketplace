<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 24/01/2017
 * Time: 21:29
 */

namespace App\Repositories\Accont;


use App\Repositories\BaseRepository;
use App\Model\Store;

class StoresRepository extends BaseRepository
{

    public function model()
    {
        return Store::class;
    }

    public function search($name){
        return $this->model->search($name)->get();
    }

    public function bySlug($slug){
        return $this->model->where(['slug'=> $slug])->first();
    }
}