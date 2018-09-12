<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 10/02/2017
 * Time: 11:31
 */

namespace App\Http\Controllers\Account;


use App\Http\Controllers\AbstractController;
use Illuminate\Container\Container as App;
use Illuminate\Http\Request;
use App\Repositories\Account\TypeMovementsStocksRepository as Repository;
use Illuminate\Support\Facades\Gate;

class TypeMovementsStocksController extends AbstractController
{

    public function __construct(App $app)
    {
        parent::__construct($app);
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
    }

    public function repo(){
        return Repository::class;
    }

    public function index(){
        $typemovementsstocks = $this->repo->all($this->columns,$this->with,[],[],15);
        return view('account.type_movement', compact('typemovementsstocks'));
    }

    public function show($id){
        $typemovementsstock = $this->repo->get($id);
        return response()->json(compact('typemovementsstock'));
    }

    public function create(){

    }

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|unique:typemovementstocks',
            'description' => 'required',
            'active'=>'required'
        ],['name.required' => 'O nome é obrigatório', 'name.unique' => 'Nome já ultilizado', 'description.required' => 'A descrição é obrigatório',
           'active.required' => 'O campo ativado é obrigatório']);
        if($typemovementsstock = $this->repo->store($request->all())){
            return response()->json(compact('typemovementsstock'),201);
        }
        return response()->json(['erro'=>'erro ao gravar'],500);
    }

    public function edit($id){
        $typemovementsstock = $this->repo->get($id);
        return response()->json(compact('typemovementsstock'));
    }

    public function update(Request $request, $id){
        $this->validate($request,[
            'name' => 'required|unique:typemovementstocks,'.$id,
            'description' => 'required',
            'active'=>'required'
        ],['name.required' => 'O nome é obrigatório', 'name.unique' => 'Nome já ultilizado', 'description.required' => 'A descrição é obrigatório',
            'active.required' => 'O campo ativado é obrigatório']);
        if($typemovementsstock = $this->repo->update($request->all(),$id)){
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