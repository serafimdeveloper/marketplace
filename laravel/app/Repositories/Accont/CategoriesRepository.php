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

}