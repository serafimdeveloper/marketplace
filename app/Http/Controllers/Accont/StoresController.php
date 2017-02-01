<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 24/01/2017
 * Time: 18:07
 */

namespace App\Http\Controllers\Accont;

use App\Http\Controllers\AbstractController;
use App\Repositories\Accont\StoresRepository;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;

class StoresController extends AbstractController
{
    public function repo()
    {
        return StoresRepository::class;
    }

    public function index(){
        $stores = $this->repo->all();
        return view('stores.index', compact('stores'));
    }

    public function create(){
        if($store = Auth::user()->salesman->store){
            return view('accont.stores', compact('store'));
        }
        return view('accont.stores');
    }


    public function store(Request $request){
        $validate = [
            'name' => 'required|unique:stores',
            'type_salesman' => 'required',
            'cpf' => 'required|cpf_mascara|unique:stores',
            'logo_file' => 'required|image|mimes:png,jpg,jpeg',
            'about' => 'required|max:500'
        ];
        if($request->type_salesman === 'J'){
            $validate['cnpj'] = 'required|cnpj_mascara|unique:stores';
            $validate['social_name'] = 'required';
            $validate['fantasy_name'] = 'required';
        }
        $this->validate($request, $validate);
        $dados = $request->except('logo_file');
        $user = Auth::user();
        $dados['salesman_id'] = $user->salesman->id;
        if($store = $this->repo->store($dados)){
            $dados['logo_file'] = $this->upload($request->logo_file,'img/loja','L'.$store->id.'V'.$dados['salesman_id'].'U'.$user->id);
            $this->repo->update($dados,$store->id);
            flash('Loja criada com sucesso!', 'accept');
            return redirect()->route('accont.salesman.stores');
        }

    }

    public function update(Request $request){
        $user = Auth::user();
        $store = $user->salesman->store;
//        dd($store);
        $validate = [
            'name' => 'required|unique:stores,name,'.$store->id,
            'type_salesman' => 'required',
            'cpf' => 'required|cpf_mascara|unique:stores,cpf,'.$store->id,
            'logo_file' => 'image|mimes:png,jpg,jpeg',
            'about' => 'required|max:500'
        ];
        if($request->type_salesman === 'J'){
            $validate['cnpj'] = 'required|cnpj_mascara|unique:stores,cnpj,'.$store->id;
            $validate['social_name'] = 'required';
            $validate['fantasy_name'] = 'required';
        }
        $this->validate($request, $validate);
        $dados = $request->except('logo_file');
        if($request->hasFile('logo_file')){
            Storage::delete('imagem/loja'.$store->logo_file);
            $dados['logo_file'] = $this->upload($request->logo_file,'imagem/loja','L'.$store->id.'V'.$user->salesman->id.'U'.$user->id);
        }
        if($this->repo->update($dados,$store->id)){
            flash('Loja atualizada com sucesso!', 'accept');
            return redirect()->route('accont.salesman.stores');
        }
        flash('Erro ao atualizar a loja!', 'error');
        return redirect()->route('accont.salesman.stores');
    }


    public function show($slug){
        $store = $this->repo->bySlug($slug);
    }

    public function searchstore(){
        return view('accont.searchstore');
    }

    public function search(Request $request){
        $stores =  $this->repo->search($request->get('name'));
        return json_encode($stores);
    }

}