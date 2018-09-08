<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 07/02/2017
 * Time: 14:24
 */

namespace App\Repositories\Accont;


use App\Model\Category;
use App\Repositories\BaseRepository;

class CategoriesRepository extends BaseRepository
{

    public function model(){
        return Category::class;
    }


    public function subcategories($category){
        $subcategories = $this->model->select('id', 'name')->where('category_id', $category)->orderBy('name','ASC')->get();
        return $subcategories;
    }

    public function search($name,array $columns = [],array $where = [], array $with = [], $orders = [], $limit = 50, $page = 1){
        $model =  $this->model->with($with)->select('categories.*')->where('categories.name','LIKE','%'.$name.'%');
        foreach ($orders as $column => $order) {
            $model = $model->orderBy($column, $order);
        }
        $model = $model->paginate($limit, $columns, 'page', $page);

        return $model;
    }
}