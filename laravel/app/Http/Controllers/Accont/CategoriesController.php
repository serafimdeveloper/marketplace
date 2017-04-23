<?php

namespace App\Http\Controllers\Accont;

use App\Http\Controllers\Accont\Admin\AbstractAdminController;
use App\Model\Product;
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


    public function show($id){
        if(Gate::denies('admin')){
            return redirect()->route('accont.home');
        }
        $category = $this->repo->get($id);
        $categories = Category::orderBy('name', 'ASC')->pluck('name','id');
        return view('layouts.parties.alert_newcategory', compact('categories', 'category'));
    }


    public function create(){
        if(Gate::denies('admin')){
            return redirect()->route('accont.home');
        }
        $categories = Category::orderBy('name', 'ASC')->pluck('name','id');
        return view('layouts.parties.alert_newcategory', compact('categories'));
    }

    public function store(Request $request){
        if(Gate::denies('admin')){
            return redirect()->route('accont.home');
        }
        $this->validate($request, ['name'=>'required'], ['name.required' => 'O nome é obrigatório']);
        $dados = $request->except('_token','id');
        $dados['category_id'] = ($dados['category_id'] === "") ? null : $dados['category_id'];
        if($category = $this->repo->store($dados)){
            flash('Categoria criada com sucesso!', 'accept');
            return redirect()->back();
        }else{
            flash('Ocorreu um erro ao criar a categória!', 'error');
            return redirect()->back();
        }
    }

    public function edit($id){

    }

    public function subcategories($category){
        $subcategories = $this->repo->subcategories($category);
        return response()->json(compact('subcategories'));
    }

    public function update(Request $request, $id){
        if(Gate::denies('admin')){
            return redirect()->route('accont.home');
        }
        $dados = $request->all();

        if(isset($request->name)){
            $this->validate($request, ['name'=>'required'], ['name.required' => 'O nome é obrigatório']);
        }
        if(isset($request->menu)){
            $dados['menu'] = ($dados['menu'] == "0" ? "1" : "0");
        }

        if($category = $this->repo->update($dados,$id)){
            flash('categoria atualizada com sucesso', 'accept');
            return redirect()->back();
        }else{
            flash('Ocorreu um erro ao atualizar a categória !', 'error');
            return redirect()->back();
        }
    }

    public function destroy($id){
        if(Gate::denies('admin')){
            return redirect()->route('accont.home');
        }

        $category = $this->repo->get($id);
        if(!count($category->products)){
            if($this->repo->delete($id)){
                return response()->json(['status' => 'accept', 'msg' => 'Categoria removida!', ], 200);
            }
            return response()->json(['status' => 'error', 'msg' => 'Ocorreu um erro ao excluir a categória!'], 500);
        }else{
            return response()->json(['status' => 'error', 'msg' => 'Primeiro remova os produtos relacionado a esta categoria!'], 403);
        }
    }

}