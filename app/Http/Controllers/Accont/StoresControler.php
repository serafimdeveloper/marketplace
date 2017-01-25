<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 24/01/2017
 * Time: 18:07
 */

namespace App\Http\Controllers\Accont;

use App\Http\Controllers\Controller;
use App\Repositories\Accont\StoresRepository;

class StoresControler extends Controller
{
    private $repo;

    public function __construct(StoresRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(){
        $stores = $this->repo->all();
        return view('stores.index', compact('stores'));
    }

    public function show($slug){
        $store = $this->repo->bySlug($slug);
    }


    public function search($nome){
        $result =  $this->store->search($nome);
        return json_encode($result);
    }
}