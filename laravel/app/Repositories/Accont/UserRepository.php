<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 12/03/2017
 * Time: 21:28
 */

namespace App\Repositories\Accont;


use App\Model\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{

    public function model(){
        return User::class;
    }



}