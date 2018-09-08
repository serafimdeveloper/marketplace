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

    public function order(array $with, $order_key){
       return $this->model->with($with)->where('key', '=', $order_key)->first();
    }

    public function search($name,array $columns = [], array $where = [], array $with = [], $orders = [], $limit = 50, $page = 1){
        $model =  $this->model->search($name, $with);
        foreach ($orders as $column => $order) {
            $model = $model->orderBy($column, $order);
        }
        $model = $model->paginate($limit, $columns, 'page', $page);

        return $model;
    }
}