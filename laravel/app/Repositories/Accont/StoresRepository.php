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

    /*public function search($name, $perPage = 5){
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $stores =  $this->model->search($name)->get();
        $stores = $stores->map(function ($store) {
            return [
                'name' => $store->name,
                'slug' => $store->slug,
                'salesman' => $store->salesman->user->name
            ];
        });
        $currentPageSearchResults = $stores->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $result = new LengthAwarePaginator($currentPageSearchResults, count($stores), $perPage);
        return $result;
    }*/

    public function search($name,array $columns = [],array $with = [], $orders = [], $limit = 50, $page = 1){
        $stores =  $this->model->search($name);
        if (!empty($with)) {
            $stores = $stores->with($with);
        }

        foreach ($orders as $column => $order) {
            $stores = $stores->orderBy($column, $order);
        }

        $stores = $stores->paginate($limit, $columns, 'page', $page);

        return $stores;
    }

    public function bySlug($slug){
        return $this->model->where(['slug'=> $slug])->first();
    }
}