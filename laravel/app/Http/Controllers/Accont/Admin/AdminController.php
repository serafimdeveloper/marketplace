<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 22/03/2017
 * Time: 14:35
 */

namespace App\Http\Controllers\Accont\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\Accont\ProductsRepository;
use App\Repositories\Accont\RequestsRepository;
use App\Repositories\Accont\SalesmanRepository;
use App\Repositories\Accont\UserRepository;
use App\Repositories\AdRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    protected $with = [];
    protected $columns = ['*'];
    protected $ordy = [];
    protected $title = '';
    protected $limit = 10;

    public function list_users(Request $request, UserRepository $repo){
        $this->with  = ['addresses','requests'];
        $this->ordy  = ['name'=>'ASC'];
        $this->title = 'Listas de Usuários';
        $data = $this->search($request, 'users', $repo);
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }

    public function list_sallesmans(Request $request, SalesmanRepository $repo){
        $this->ordy = ['name' => 'ASC'];
        $this->title = 'Vendedores cadastrado na loja';
        $data = $this->search($request, 'sallesmans', $repo);
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }

    public function list_products(Request $request, ProductsRepository $repo){
        $this->ordy = ['name' => 'ASC'];
        $this->title = 'Lista de Todos os Produtos';
        $data = $this->search($request, 'products', $repo);
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }

    public function list_sales(Request $request, RequestsRepository $repo){
        $this->ordy = ['name' => 'ASC'];
        $this->title = 'Vendas / Comissões';
        $data = $this->search($request, 'sales', $repo);
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }

    public function list_banners(Request $request, AdRepository $repo){
        $this->ordy = ['name' => 'ASC'];
        $this->title = 'Banners';
        $data = $this->search($request, 'banners', $repo);
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }


    private function search($request, $type, $repo){
        $page = Input::get('page') ? Input::get('page') : 1 ;
        $result = $repo->search($request->name, $this->columns, $this->with, $this->ordy, $this->limit = 10, $page);
        return ['type' => $type, 'result' => $result, 'title' => $this->title];

    }

}