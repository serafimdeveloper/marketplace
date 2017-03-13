<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 11/03/2017
 * Time: 14:49
 */

namespace App\Repositories;


use App\Model\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoritesRepository extends BaseRepository
{

    public function model()
    {
        return Favorite::class;
    }

    public function getProductsFavorites(){
        $favorites = Auth::user()->favorites;
        $stores = [];
        foreach($favorites as $favorite){
            $store =$favorite->product->store;
            $stores[$store->id]['store'] = $store;
            $stores[$store->id]['products'][] = $favorite->product;
        }
        return $stores;
    }
}