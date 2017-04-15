<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 12/04/2017
 * Time: 20:30
 */

namespace App\Http\Controllers\Accont\Admin;

use App\Repositories\Accont\SalesmanRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SalesmanController extends AbstractAdminController {
    public function __construct(SalesmanRepository $repo){
        $this->repo = $repo;
    }

    public function index(Request $request){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_accont');
        }
        $this->ordy = ['name' => 'ASC'];
        $this->title = 'Vendedores Cadastrado no Sistema';
        $this->placeholder = 'Pesquisar por nome ou email';
        $data = $this->search($request, 'sallesmans');
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }

        return view('accont.report.search', $data);
    }

    public function show($id){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_accont');
        }
        $this->with = ['user', 'store'];
        if($result = $this->getByRepoId($id)){
            $result->read = 1;
            $result->save();
            $type = 'vendedor';

            return view('layouts.parties.alert_salesman_info', compact('result', 'type'));
        }

        return response()->json(['msg' => 'Erro ao encontrar o vendedor'], 404);
    }

    public function change($id){
        if($salesman = $this->repo->get($id)){
            if($salesman->active){
                $salesman->update(['active' => 0]);
            }else{
                $salesman->update(['active' => 1]);
            }
            return response()->json(['status'=>$salesman->active],200);
        }

        return response()->json(['status' => false], 500);
    }

    public function update(Request $request, $id){
        if($salesman = $this->repo->get($id)) {
            $salesman->update($request->all());
            return response()->json(['status' => true], 200);
        }
        return response()->json(['status' => false, 500]);
    }

    public function destroy($id){
        if($salesman = $this->repo->get($id)){
            $salesman->delete();
            return response()->json([], 204);
        }
        return response()->json(['status' => false], 500);
    }
}