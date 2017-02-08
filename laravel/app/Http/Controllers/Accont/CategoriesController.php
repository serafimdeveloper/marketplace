<?php

namespace App\Http\Controllers\Accont;


use App\Http\Controllers\AbstractController;
use App\Http\Requests\Request;
use App\Model\Category;
use App\Repositories\Accont\CategoriesRepository;

class CategoriesController extends AbstractController
{
    public function repo(){
        return CategoriesRepository::class;
    }

    public function index(){
        $categories = $this->repo->all($this->columns,$this->with);
        return view('accont.categories', compact('categories'));
    }

    public function create(){
        $categories = Category::pluck('name','id');
        return response()->json(compact('categories'));
    }

    public function store(Request $request){
        $this->validate($request, ['name'=>'required|unique:categories']);
        $dados = $request->all();
        if($category = $this->repo->store($dados)){
            return response()->json(['status'=>true, 'category'=>$category],201);
        }else{
            return response()->json(['status'=>false,'msg'=>'Ocorreu um erro ao criar a categória !'], 500);
        }
    }

    public function edit($id){
        $category = $this->repo->get($id);
        $categories = $this->repo->all();
        response()->json(compact('category','categories'));
    }

    public function update(Request $request, $id){
        $this->validate($request, ['name'=>'required|unique:categories,name,'.$id]);
        $dados = $request->all();
        if($category = $this->repo->update($dados,$id)){
            return response()->json(['status'=>true, 'category'=>$category],201);
        }else{
            return response()->json(['status'=>false,'msg'=>'Ocorreu um erro ao atualizar a categória !'], 500);
        }
    }

    public function destroy($id){
        if($this->repo->delete($id)){
            return response()->json(['status'=>true,'msg'=>'Excluido com sucesso'],200);
        }
        return response()->json(['status'=>false,'msg'=>'Ocorreu um erro ao excluir a categória !'], 500);
    }

}