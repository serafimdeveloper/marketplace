<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 22/03/2017
 * Time: 14:35
 */

namespace App\Http\Controllers\Accont\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\Accont\UserRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $user;
    protected $with_user = [];
    public function __construct(UserRepository $user){
        $this->user = $user;
    }

    public function list_users(Request $request){
        $this->search($request, 'users');
    }

    public function list_sallesmans(Request $request){
        $this->search($request, 'sallesmans');
    }

    public function list_products(Request $request){
        $this->search($request, 'products');
    }

    private function search($request, $type, $repo){
        $page = Input::get('page') ? Input::get('page') : 1 ;
        $result = $repo->search($request->name, $this->columns, $this->with, ['name'=>'ASC'], $limit = 10, $page);
        if($request->ajax()){
            return view('accont.presearch', compact('result','type'));
        }
        return view('accont.search', compact('result', 'type'));

    }

}