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
    protected $limit = 3;

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

    public function get_user_id(UserRepository $repo, $id){
        $this->with  = ['addresses','requests'];
        $type = 'usuario';
        if($result = $this->getByRepoId($repo, $id)){
            return view('layouts.parties.alert_user_info', compact('result','type'));
        }
        return response()->json(['msg' => 'Erro ao encontrar o usuário'],404);
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

    public function get_sallesman_id(SalesmanRepository $repo, $id){
        $this->with = ['user','store'];
        if($result = $this->getByRepoId($repo, $id)){
            $type = 'vendedor';
            return view('layouts.parties.alert_salesman_info', compact('result','type'));
        }
        return response()->json(['msg' => 'Erro ao encontrar o vendedor'],404);
    }

    public function list_products(Request $request, ProductsRepository $repo){
        $this->ordy = ['name' => 'ASC'];
        $this->with = ['store','galeries'];
        $this->title = 'Lista de Todos os Produtos';
        $data = $this->search($request, 'products', $repo);
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }

    public function get_product_id(ProductsRepository $repo, $id){
        if($result = $this->getByRepoId($repo, $id)){
            return view('layouts.parties.alert_product_info', compact('result'));
        }
        return response()->json(['msg' => 'Erro ao encontrar o produto'],404);
    }

    public function list_sales(Request $request, RequestsRepository $repo){
        $this->ordy = ['created_at' => 'DES'];
        $this->title = 'Vendas / Comissões';
        $this->with = ['store','user','adress','freight','products','requeststatus'];
        $data = $this->search($request, 'sales', $repo);
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }

    public function get_sale_id(SalesmanRepository $repo, $id){
        $this->with = ['store','user','adress','freight','products','requeststatus'];
        if($result = $this->getByRepoId($repo, $id)){
            return view('layouts.parties.alert_sales_info', compact('result'));
        }
        return response()->json(['msg' => 'Erro ao encontrar o vendedor'],404);
    }

    public function list_banners(Request $request, AdRepository $repo){
        $this->ordy = ['name' => 'ASC'];
        $this->with = ['store'];
        $this->title = 'Banners';
        $data = $this->search($request, 'banners', $repo);
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }

    public function get_banner_id(AdRepository $repo, $id){
        if($result = $this->getByRepoId($repo, $id)){
            return response()->json(compact('result'));
        }
        return response()->json(['msg' => 'Erro ao encontrar o vendedor'],404);
    }

    private function search($request, $type, $repo){
        $page = Input::get('page') ? Input::get('page') : 1 ;
        $result = $repo->search($request->name, $this->columns, $this->with, $this->ordy, $this->limit, $page);
        return ['type' => $type, 'result' => $result, 'title' => $this->title];

    }

    private function getByRepoId($repo, $id){
        if($result = $repo->get($id,$this->columns,$this->with)){
            return $result;
        }
        return false;
    }


}