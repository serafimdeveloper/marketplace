<?php

namespace App\Repositories\Accont;
use App\Repositories\BaseRepository;
use App\Model\Salesman;

class SalesmanRepository extends BaseRepository
{
    public function model(){
        return Salesman::class;
    }

    public function search($name,array $columns = [],array $with = [], $orders = [], $limit = 50, $page = 1){
        $model =  $this->model->with($with)->select('salesmans.*')->join('users', function($join) use($name){
            $join->on('users.id','=','salesmans.user_id')
                ->where('users.name','LIKE','%'.$name.'%');
        });
        foreach ($orders as $column => $order) {
            $model = $model->orderBy($column, $order);
        }
        $model = $model->paginate($limit, $columns, 'page', $page);
        return $model;
    }

}