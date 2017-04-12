<?php

namespace App\Http\Controllers\Accont;

use App\Http\Controllers\AbstractController;
use Illuminate\Container\Container as App;
use Illuminate\Http\Request;
use App\Model\Category;
use App\Repositories\Accont\CategoriesRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;

class CategoriesController extends AbstractController
{
    public function __construct(App $app) {
        parent::__construct($app);
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
    }

    public function repo(){
        return CategoriesRepository::class;
    }

    public function index(){
        $page = Input::get('page');
        $categories = $this->repo->all($this->columns,$this->with,[],['name'=>'ASC'],10,$page);
        return view('accont.categories', compact('categories'));
    }

    public function create(){
        $categories = Category::pluck('name','id');
        return response()->json(compact('categories'));
    }

    public function store(Request $request){
        $this->validate($request, ['name'=>'required|unique:categories'], ['name.required' => 'O nome é obrigatório', 'name.unique' => 'O nome é único']);
        $dados = $request->except('_token','id');
        $dados['category_id'] = ($dados['category_id'] === "") ? null : $dados['category_id'];
        if($category = $this->repo->store($dados)){
            return response()->json(['status'=>true, 'category'=>$category],201);
        }else{
            return response()->json(['status'=>false,'msg'=>'Ocorreu um erro ao criar a categória !'], 500);
        }
    }

    public function edit($id){

        $category = $this->repo->get($id);
        $categories = Category::pluck('name','id');
        return response()->json(compact('categories','category'));
    }

    public function subcategories($category){
        $subcategories = $this->repo->subcategories($category);
        return response()->json(compact('subcategories'));
    }

    public function update(Request $request, $id){
        $this->validate($request, ['name'=>'required|unique:categories,name,'.$id], ['name.required' => 'O nome é obrigatório', 'name.unique' => 'O nome é único']);
        $dados = $request->all();
        if($category = $this->repo->update($dados,$id)){
            return response()->json(['status'=>true, 'category'=>$category],201);
        }else{
            return response()->json(['status'=>false,'msg'=>'Ocorreu um erro ao atualizar a categória !'], 500);
        }
    }

    public function destroy($id){
        if($this->repo->delete($id)){
            return response()->json(['msg'=>'Excluído com sucesso'],200);
        }
        return response()->json(['msg'=>'Ocorreu um erro ao excluir a categória !'], 500);
    }

}