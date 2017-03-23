<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 31/01/2017
 * Time: 14:49
 */

namespace App\Repositories\Accont;


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
            ->join('stores', function ($join) use ($store) {
                $join->on('stores.id', '=', 'products.store_id')
                    ->where('stores.slug', $store);
            })
            ->join('categories', function ($join) use ($category) {
                $join->on('categories.id', '=', 'products.category_id')
                    ->where('categories.slug', $category);
            })
            ->where('products.slug', $product)->where('products.quantity','>',0)->where('products.active',1);
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
        $model = $this->model->with($with)->select('products.*', DB::raw('SUM(product_request.quantity) AS qtd_product_request'))
            ->leftJoin('product_request', 'products.id','=','product_request.product_id')
            ->join('stores', 'products.store_id','=','stores.id')
            ->where('products.quantity','>',0)->where('products.active',1)
            ->where('stores.active',1)->where('stores.blocked',0)
            ->groupBy('id', 'store_id', 'name', 'category_id', 'quantity', 'price', 'price_out_discount', 'slug', 'deadline',
            'free_shipping', 'minimum_stock', 'details', 'length_cm', 'width_cm', 'height_cm', 'weight_gr', 'diameter_cm',
            'active', 'created_at', 'updated_at')
            ->orderBy('qtd_product_request','desc')
            ->limit(15)
            ->get();
        return $model;

    }

    public function getMostVisited(array $with){
        $model = $this->model->with($with)
            ->select('products.*', DB::raw('SUM(visit_products.count) AS qtd_product_visit'))
            ->leftJoin('visit_products', 'products.id','=','visit_products.product_id')
            ->join('stores', 'products.store_id','=','stores.id')
            ->where('products.quantity','>',0)->where('products.active',1)
            ->where('stores.active',1)->where('stores.blocked',0)
            ->groupBy('id', 'store_id', 'name', 'category_id', 'quantity', 'price', 'price_out_discount', 'slug', 'deadline',
                'free_shipping', 'minimum_stock', 'details', 'length_cm', 'width_cm', 'height_cm', 'weight_gr', 'diameter_cm',
                'active', 'created_at', 'updated_at')
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
            ->select('products.*')->where('category_id', $category)
            ->join('stores', 'products.store_id','=','stores.id')
            ->where('products.quantity','>',0)->where('products.active',1)
            ->where('stores.active',1)->where('stores.blocked',0)
            ->get();
        return $model;
    }

    public function getNews(array $with){
        $model = $this->model->with($with)->distinct()
            ->select('products.*')
            ->join('stores', 'products.store_id','=','stores.id')
            ->where('products.quantity','>',0)->where('products.active',1)
            ->where('stores.active',1)->where('stores.blocked',0)
            ->orderBy('products.created_at', 'desc')
            ->limit(20)
            ->get();
        return $model;
    }

    public function getSubCategory(array $with, $category, $subcategory = null){
        $model = $this->model->with($with)->distinct()
            ->select('products.*')
            ->join('stores', 'products.store_id','=','stores.id')
            ->whereIn('category_id', function($query) use($category, $subcategory){
                $query->select('id')->from('categories')->where('category_id', $category);
                if($subcategory){
                    $query->where('category.slug', $subcategory);
                }
            })
            ->where('products.quantity','>',0)->where('products.active',1)
            ->where('stores.active',1)->where('stores.blocked',0)
            ->where('products.quantity','>',0)->where('products.active',1)
            ->get();
        return $model;
    }

    public function productsCategory(array $with,$category, $subcategory = null){
        $model_cat = Category::where('slug', $category)->first();
        $categories = $this->getCategory($with, $model_cat->id);
        $all = $categories->merge($this->getSubCategory($with, $model_cat->id, $subcategory));
        return $all;
    }

    public function search($name,array $columns = [],array $with = [], $orders = [], $limit = 50, $page = 1){
        $model =  $this->model->Search($name, $with);
        foreach ($orders as $column => $order) {
            $model = $model->orderBy($column, $order);
        }
        $model = $model->paginate($limit, $columns, 'page', $page);

        return $model;
    }

    public function searchProducts(array $with, $search){
        $model = $this->model->Search($search, $with)
            ->join('stores', 'products.store_id','=','stores.id')
            ->where('products.quantity','>',0)->where('products.active',1)
            ->where('stores.active',1)->where('stores.blocked',0)
            ->get();
        return $model;
    }

    public function countRequests($product){
        $requests = $product->requests->where('request_status_id',6)
            ->sum(function($request){
               return  $request->pivot->quantity;
            });
        return $requests;
    }

}
