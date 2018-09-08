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
use Illuminate\Pagination\LengthAwarePaginator;

class StoresRepository extends BaseRepository
{

    public function model()
    {
        return Store::class;
    }

    public function search($name,array $columns = [],array $with = [], $orders = [], $limit = 50, $page = 1){
        $stores =  $this->model->search($name,$with)->where('blocked',0)->where('active',1);
        foreach ($orders as $column => $order) {
            $stores = $stores->orderBy($column, $order);
        }

        $stores = $stores->paginate($limit, $columns, 'page', $page);

        return $stores;
    }

    public function getStoreSlug(array $with, $slug){
        return $this->model->with($with)->where(['slug'=> $slug])->first();
    }
}