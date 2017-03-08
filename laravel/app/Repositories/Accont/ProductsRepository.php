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
use Illuminate\Support\Facades\DB;

class ProductsRepository extends BaseRepository
{
    public function model(){
        return Product::class;
    }
    public function single_page(array $with, $store, $category, $product)
    {
        $model = $this->model
            ->with($with)
            ->join('stores', function ($join) use ($store) {
                $join->on('stores.id', '=', 'products.store_id')
                    ->where('stores.slug', $store);
            })
            ->join('categories', function ($join) use ($category) {
                $join->on('categories.id', '=', 'products.category_id')
                    ->where('categories.slug', $category);
            })
            ->select('products.*')
            ->where('products.slug', $product)
            ->get();
        return $model->first();
    }

    /*
        SELECT DISTINCT products.*,
        SUM(product_request.quantity) AS qtd_product_request
        FROM products
        LEFT JOIN product_request ON products.id = product_request.product_id
        GROUP BY products.id
        ORDER BY qtd_product_request DESC
        LIMIT 5

        SELECT DISTINCT products.*,
        SUM(visit_products.count) AS qtd_product_visit
        FROM products
        LEFT JOIN visit_products ON products.id = visit_products.product_id
        GROUP BY products.id
        ORDER BY qtd_product_visit DESC
        LIMIT 5
     *
     */


    public function getBestSellers(array $with){
       /* $model = $this->model->with($with)->distinct()
            ->select(DB::raw('products.*'))
            ->leftJoin('product_request','products.id','=','product_request.product_id')
            ->groupBy('id')
            ->orderBy(DB::raw('SUM(product_request.quantity)'),'desc')
            ->get();
        return $model;*/
       $model = $this->model->with($with)->get();
       $collection = $model->sortByDesc(function($product){
           return $product->requests->each(function($request){
               return count($request->pivot->quantity);
           });
       });
       return $collection->splice(15);
    }

    public function getMostVisited(array $with){
        $model = $this->model->with($with)->distinct()->get();
        $collection = $model->sortByDesc(function($product){
            return $product->visitproduct->each(function ($visit){
                return count($visit->count);
            });
        });
        return $collection->splice(15);
    }

    public function getHighlights(array $with){
        $collection = $this->getBestSellers($with);
        $all = $collection->merge($this->getMostVisited($with));
        if($all->count() >= 10){
            $all = $all->random(20);
        }
        return $all->all();
    }
}