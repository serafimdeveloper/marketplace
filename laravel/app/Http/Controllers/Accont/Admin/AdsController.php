<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 12/04/2017
 * Time: 20:44
 */

namespace App\Http\Controllers\Accont\Admin;


use App\Repositories\AdRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdsController extends  AbstractAdminController
{
    public function __construct(AdRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_accont');
        }
        $this->ordy = ['name' => 'ASC'];
        $this->with = ['store'];
        $this->title = 'Banners';
        $data = $this->search($request, 'banners');
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }

    public function show($id){
        if($result = $this->getByRepoId($id)){
            return response()->json(compact('result'));
        }
        return response()->json(['msg' => 'Erro ao encontrar o vendedor'],404);
    }
}