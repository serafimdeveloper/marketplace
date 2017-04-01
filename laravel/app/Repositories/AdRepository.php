<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 11/03/2017
 * Time: 14:49
 */

namespace App\Repositories;


use App\Ad;
use Illuminate\Support\Facades\Auth;

class AdRepository extends BaseRepository
{

    public function model()
    {
        return Ad::class;
    }

    public function search($name,array $columns = [],array $with = [], $orders = [], $limit = 50, $page = 1){
        $model =  $this->model->search($name, $with);
        foreach ($orders as $column => $order) {
            $model = $model->orderBy($column, $order);
        }
        $model = $model->paginate($limit, $columns, 'page', $page);

        return $model;
    }

}