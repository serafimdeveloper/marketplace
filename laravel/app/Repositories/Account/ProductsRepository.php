<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 31/01/2017
 * Time: 14:49
 */

namespace App\Repositories\Account;


use App\Model\Category;
use App\Model\Product;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class ProductsRepository extends BaseRepository
{
    public function model(){
        return Product::class;
    }
    public function single_page(array $with, $store, $category, $product) {
        $model = $this->model
            ->with($with)
            ->select('products.*')
            ->join('stores', function($join) use($store){
                $join->on('stores.id','=','products.store_id')
                    ->where('stores.slug', $store);
            })
            ->join('categories', function ($join) use ($category) {
                $join->on('categories.id', '=', 'products.category_id')
                    ->where('categories.slug', $category);
            })
            ->where('products.slug', $product);
        return $model->first();
    }

    public function getBestSellers(array $with){
        $model = $this->model->with($with)->select('products.*', DB::raw('SUM(product_request.quantity) AS qtd_product_request'))
            ->leftJoin('product_request', 'products.id','=','product_request.product_id');
        $model = $this->productsActive($model)
            ->groupBy('id', 'store_id', 'name', 'category_id', 'quantity', 'price', 'price_out_discount', 'slug', 'deadline',
            'free_shipping', 'minimum_stock', 'details', 'length_cm', 'width_cm', 'height_cm', 'weight_gr',
            'active', 'created_at', 'updated_at','deleted_at')
            ->orderBy('qtd_product_request','desc')
            ->limit(15)
            ->get();
        return $model;

    }

    public function getMostVisited(array $with){
        $model = $this->model->with($with)
            ->select('products.*', DB::raw('SUM(visit_products.count) AS qtd_product_visit'))
            ->leftJoin('visit_products', 'products.id','=','visit_products.product_id');
        $model = $this->productsActive($model)
            ->groupBy('id', 'store_id', 'name', 'category_id', 'quantity', 'price', 'price_out_discount', 'slug', 'deadline',
                'free_shipping', 'minimum_stock', 'details', 'length_cm', 'width_cm', 'height_cm', 'weight_gr',
                'active', 'created_at', 'updated_at','deleted_at')
            ->orderBy('qtd_product_visit', 'desc')
            ->limit(15)
            ->get();
        return $model;
    }

    public function getHighlights(array $with){
        $collection = $this->getBestSellers($with);
        $all = $collection->merge($this->getMostVisited($with));
        $shuffle = $all->shuffle();
        return $shuffle->all();
    }

    public function getCategory( array $with, $category){
        $model = $this->model->with($with)->distinct()
            ->select('products.*')->where('category_id', $category);
        $model = $this->productsActive($model)
            ->get();
        return $model;
    }

    public function getNews(array $with){
        $model = $this->model->with($with)->distinct()
            ->select('products.*');
        $model = $this->productsActive($model)
            ->orderBy('products.created_at', 'desc')
            ->limit(20)
            ->get();
        return $model;
    }

    public function getSubCategory(array $with, $category, $subcategory = null){
        $model = $this->model->with($with)->distinct()
            ->select('products.*');
        $model = $this->productsActive($model)
            ->whereIn('category_id', function($query) use($category, $subcategory){
                $query->select('id')->from('categories')->where('category_id', $category);
                if($subcategory){
                    $query->where('category.slug', $subcategory);
                }
            })->get();
        return $model;
    }



    public function productsCategory(array $with,$category, $subcategory = null){
        $model_cat = Category::where('slug', $category)->first();
        $categories = $this->getCategory($with, $model_cat->id);
        $all = $categories->merge($this->getSubCategory($with, $model_cat->id, $subcategory));
//        dd($all);
        return $all;
    }

    public function search($name,array $columns = [],array $where = [], array $with = [], $orders = [], $limit = 50, $page = 1){
        $model =  $this->model->Search($name, $with);
        foreach ($where as $key => $value){
            $model = $model->where($key, $value);
        }
        foreach ($orders as $column => $order) {
            $model = $model->orderBy($column, $order);
        }
        $model = $model->paginate($limit, $columns, 'page', $page);
        return $model;
    }

    public function searchProducts(array $with, $search){
        $model = $this->model->Search($search, $with)
            ->select('products.*');
        $model = $this->productsActive($model)->get();
//        dd($model);
        return $model;
    }

    public function countRequests($product){
        $requests = $product->requests->where('request_status_id',8)
            ->sum(function($request){
               return  $request->pivot->quantity;
            });
        return $requests;
    }

    private function productsActive($model){
      $model->join('stores',function($join){
          $join->on('products.store_id','=','stores.id')
              ->where('stores.active',1);
      })->join('sellers', function($join){
          $join->on('sellers.id','=','stores.seller_id')
              ->where('sellers.active',1);
      })->where('products.quantity','>',0)->where('products.active',1);
      return $model;
    }

}
