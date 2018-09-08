<?php

namespace App\Repositories\Accont;
use App\Repositories\BaseRepository;
use App\Model\Seller;

class SalesmanRepository extends BaseRepository
{
    public function model(){
        return Seller::class;
    }

    public function search($name,array $columns = [], array $where = [], array $with = [], $orders = [], $limit = 50, $page = 1){
        $model =  $this->model->with($with)->select('sellers.*')->join('users', function($join) use($name){
            $join->on('users.id','=','sellers.user_id')
                ->where('users.name','LIKE','%'.$name.'%');
        });
        foreach ($orders as $column => $order) {
            $model = $model->orderBy($column, $order);
        }
        $model = $model->paginate($limit, $columns, 'page', $page);
        return $model;
    }

}