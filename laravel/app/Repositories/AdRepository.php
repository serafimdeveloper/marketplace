<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 11/03/2017
 * Time: 14:49
 */

namespace App\Repositories;


use App\Model\Ad;

class AdRepository extends BaseRepository
{

    public function model()
    {
        return Ad::class;
    }

    public function search($name,array $columns = [],array $where = [], array $with = [], $orders = [], $limit = 50, $page = 1){
        $model =  $this->model->with($with)->select('ads.*')->join('stores', function($join) use($name) {
            $join->on('stores.id','=','ads.store_id')
                ->where('stores.name','LIKE','%'.$name.'%');
        });
        foreach ($orders as $column => $order) {
            $model = $model->orderBy($column, $order);
        }
        $model = $model->paginate($limit, $columns, 'page', $page);

        return $model;
    }

}