<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 12/04/2017
 * Time: 20:27
 */

namespace App\Http\Controllers\Account\Admin;


use App\Repositories\Account\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends AbstractAdminController
{
    public function __construct( UserRepository $repo)
    {
      $this->repo = $repo;
    }
    public function index(Request $request){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_account');
        }
        $this->with  = ['addresses','requests'];
        $this->ordy  = ['name'=>'ASC'];
        $this->title = 'Listas de Usuários';
        $this->placeholder = 'Pesquisar por nome ou email';
        $data = $this->search($request, 'users');
        if($request->ajax()){
            return view('account.report.presearch', $data);
        }
        return view('account.report.search', $data);
    }

    public function show($id){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_account');
        }
        $this->with  = ['addresses','requests'];
        $type = 'usuario';
        if($result = $this->getByRepoId($id)){
            return view('layouts.parties.alert_user_info', compact('result','type'));
        }
        return response()->json(['msg' => 'Erro ao encontrar o usuário'],404);
    }

    public function destroy($id){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_account');
        }
        if($user = $this->repo->get($id)){
            $user->delete();
            return response()->json([],204);
        }
        return response()->json(['status'=>false],500);
    }

}