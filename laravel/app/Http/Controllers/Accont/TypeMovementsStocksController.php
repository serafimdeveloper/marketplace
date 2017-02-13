<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 10/02/2017
 * Time: 11:31
 */

namespace App\Http\Controllers\Accont;


use App\Http\Controllers\AbstractController;
use Illuminate\Http\Request;
use App\Repositories\Accont\TypeMovementsStocksRepository as Repository;
class TypeMovementsStocksController extends AbstractController
{

    public function repo(){
        return Repository::class;
    }

    public function index(){
        $typemovementsstocks = $this->repo->all($this->columns,$this->with,[],[],15);
        return view('accont.type_movement', compact('typemovementsstocks'));
    }

    public function show($id){
        $typemovementsstock = $this->repo->get($id);
        return response()->json(compact('$typemovementsstock'));
    }

    public function create(){

    }

    public function store(Request $request){
        $dados = $request->all();
        $this->validate($dados,[
            'name' => 'required|unique:typemovementstocks',
            'description' => 'required',
            'active'=>'required'
        ]);
        if($typemovementsstock = $this->repo->store($dados)){
            return response()->json(compact('$typemovementsstock'),201);
        }
        return response()->json(['erro'=>'erro ao gravar'],500);
    }

    public function edit($id){
        $typemovementsstock = $this->repo->get($id);
        return response()->json(compact('typemovementsstock'));
    }

    public function update(Request $request, $id){
        $dados = $request->all();
        $this->validate($dados,[
            'name' => 'required|unique:typemovementstocks,'.$id,
            'description' => 'required',
            'active'=>'required'
        ]);
        if($typemovementsstock = $this->repo->update($dados,$id)){
            return response()->json(compact('$typemovementsstock'),200);
        }
        return response()->json(['erro'=>'erro ao gravar'],500);
    }

    public function destroy($id){
        if($this->repo->delete($id)){
            return response()->json([],204);
        }
        return response()->json(['erro'=>'erro ao excluir'],500);

    }
}