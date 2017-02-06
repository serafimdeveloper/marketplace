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
}