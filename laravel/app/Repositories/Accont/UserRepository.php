<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 12/03/2017
 * Time: 21:28
 */

namespace App\Repositories\Accont;


use App\Model\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{

    public function model(){
        return User::class;
    }

    public function search($name,array $columns = [],array $with = [], $orders = [], $limit = 50, $page = 1){
        $model =  $this->model->search($name, $with)->where('type_user','client');
        foreach ($orders as $column => $order) {
            $model = $model->orderBy($column, $order);
        }
        $model = $model->paginate($limit, $columns, 'page', $page);

        return $model;
    }

    public function getUser(array $with, $wheres){
        $model = $this->model->with($with);
        foreach($wheres as $key => $value){
            $model = $model->where($key,$value);
        }
        return $model->first();
    }

}