<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 11/03/2017
 * Time: 14:48
 */

namespace App\Http\Controllers;


use App\Repositories\FavoritesRepository;

class FavoritesController extends AbstractController
{

    public function repo()
    {
        return FavoritesRepository::class;
    }

    public function index(){
        return view('pages.favorites');
    }
}