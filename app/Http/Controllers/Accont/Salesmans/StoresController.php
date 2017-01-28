<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 27/01/2017
 * Time: 10:55
 */

namespace App\Http\Controllers\Accont\Salesmans;

use App\Http\Controllers\AbstractController;
use App\Repositories\Accont\StoresRepository;

class StoresController extends AbstractController
{

    public function repo()
    {
        return StoresRepository::class;
    }

    public function index(){

    }

    public function store(){

    }
}