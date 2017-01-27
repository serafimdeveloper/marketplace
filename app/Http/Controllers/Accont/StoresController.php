<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 24/01/2017
 * Time: 18:07
 */

namespace App\Http\Controllers\Accont;

use Illuminate\Container\Container as App;
use App\Http\Controllers\AbstractController;
use App\Repositories\Accont\StoresRepository;
use Illuminate\Http\Request;

class StoresController extends AbstractController
{
    public function repo()
    {
        return StoresRepository::class;
    }

    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    public function index(){
        $stores = $this->repo->all();
        return view('stores.index', compact('stores'));
    }

    public function show($slug){
        $store = $this->repo->bySlug($slug);
    }

    public function searchstore(){
        return view('accont.searchstore', compact('stores'));
    }



    public function search(Request $request){
        $stores =  $this->repo->search($request->get('name'));
        return json_encode($stores);
    }

}