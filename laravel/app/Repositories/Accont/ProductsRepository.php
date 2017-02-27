<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 31/01/2017
 * Time: 14:49
 */

namespace App\Repositories\Accont;


use App\Model\Product;
use App\Repositories\BaseRepository;

class ProductsRepository extends BaseRepository
{
    public function model(){
        return Product::class;
    }
    public function single_page(array $with, $store, $category, $product){
        $model = $this->model
            ->with($with)
            ->join('stores', function($join) use($store){
                $join->on('stores.id','=','products.store_id')
                    ->where('stores.slug',$store);
            })
            ->join('categories', function($join) use($category){
                $join->on('categories.id','=','products.category_id')
                    ->where('categories.slug',$category);
            })
            ->select('products.*')
            ->where('products.slug',$product)
            ->get();
        return $model->first();
    }
}