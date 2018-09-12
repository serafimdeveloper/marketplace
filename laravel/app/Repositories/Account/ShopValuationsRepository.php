<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 17/02/2017
 * Time: 02:57
 */

namespace App\Repositories\Account;


use App\Model\ShopValuation;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class ShopValuationsRepository extends BaseRepository
{
    public function model(){
        return ShopValuation::class;
    }

    public function getNotes($product){
        $model = $this->model->select('shop_valuations.*', DB::raw('avg(note_products) as medium_product, avg(note_attendance) as medium_attendance'))->distinct()
            ->where('store_id',$product->store_id)
            ->groupBy('id','user_id','store_id','request_id','note_products','note_attendance','comment','return_reason', 'active','created_at','updated_at')
            ->get();
        return $model;
    }

}