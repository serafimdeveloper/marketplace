<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 11/03/2017
 * Time: 14:49
 */

namespace App\Repositories;


use App\Ad;
use Illuminate\Support\Facades\Auth;

class AdRepository extends BaseRepository
{

    public function model()
    {
        return Ad::class;
    }

}