<?php

namespace App\Http\Controllers\Accont;

use App\Http\Controllers\Accont\Admin\AbstractAdminController;
use Illuminate\Container\Container as App;
use Illuminate\Http\Request;
use App\Model\Category;
use App\Repositories\Accont\CategoriesRepository;
use Illuminate\Support\Facades\Gate;

class CategoriesController extends AbstractAdminController
{
    protected $repo;
    public function __construct(CategoriesRepository $repository)
    {
        $this->repo = $repository;
    }

    public function index(Request $request){
        if(Gate::denies('admin')){
            return redirect()->route('accont.home');
        }
        $this->ordy = ['name' => 'ASC'];
        $this->with = ['products'];
        $this->title = 'Categorias cadastrada no sistema';
        $this->placeholder = "Pesquisar por nome de categoria";

        $data = $this->search($request, 'categories');

        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }
    public function show(Request $request){

    }
    public function create(){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_accont');
        }
        $categories = Category::pluck('name','id');
        return response()->json(compact('categories'));
    }

    public function store(Request $request){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_accont');
        }
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
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_accont');
        }
        $category = $this->repo->get($id);
        $categories = Category::pluck('name','id');
        return response()->json(compact('categories','category'));
    }

    public function subcategories($category){
        $subcategories = $this->repo->subcategories($category);
        return response()->json(compact('subcategories'));
    }

    public function update(Request $request, $id){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_accont');
        }
        $this->validate($request, ['name'=>'required|unique:categories,name,'.$id], ['name.required' => 'O nome é obrigatório', 'name.unique' => 'O nome é único']);
        $dados = $request->all();
        if($category = $this->repo->update($dados,$id)){
            return response()->json(['status'=>true, 'category'=>$category],201);
        }else{
            return response()->json(['status'=>false,'msg'=>'Ocorreu um erro ao atualizar a categória !'], 500);
        }
    }

    public function destroy($id){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_accont');
        }
        if($this->repo->delete($id)){
            return response()->json(['msg'=>'Excluído com sucesso'],200);
        }
        return response()->json(['msg'=>'Ocorreu um erro ao excluir a categória !'], 500);
    }

}