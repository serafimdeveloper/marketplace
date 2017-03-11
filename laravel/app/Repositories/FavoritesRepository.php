<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 11/03/2017
 * Time: 14:49
 */

namespace App\Repositories;


class FavoritesRepository extends BaseRepository
{

    public function model()
    {
        return Favorites::class;
    }
}