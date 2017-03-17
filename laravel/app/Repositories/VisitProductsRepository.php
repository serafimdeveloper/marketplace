<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 17/03/2017
 * Time: 10:19
 */

namespace App\Repositories;


use App\Model\VisitProduct;
use Illuminate\Support\Facades\Auth;

class VisitProductsRepository extends BaseRepository
{

    public function model()
    {
        return VisitProduct::class;
    }

    public function add_visit_product($product){
        $product = $this->model->product()->where('slug',$product)->first();
        if(Auth::check()){
            $user = Auth::user();
            if($visitproduct = $user->visitproducts->where('product_id',$product->id)->first()){
                $visitproduct->increment('count');
            }else{
               $user->visitproducts()->create(['product_id'=>$product->id,'count'=>1]);
            }
        }else{
            if($visitproduct = $this->model->where('product_id', $product->id)->whereNull('user_id')->first()){
                $visitproduct->increment('count');
            }else{
                $this->store(['product_id' => $product->id,'count' => 1]);
            }
        }
    }

}