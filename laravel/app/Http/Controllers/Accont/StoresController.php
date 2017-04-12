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
use Auth;
use Illuminate\Container\Container as App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class StoresController extends AbstractController
{

    public function __construct(App $app)
    {
        parent::__construct($app);
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
    }

    public function repo()
    {
        return StoresRepository::class;
    }

    public function index(){
        $stores = $this->repo->all();
        return view('stores.index', compact('stores'));
    }

    public function create(){
        if(Gate::denies('vendedor')){
           return  redirect()->route('accont.home');
        }
        $salesman = Auth::user()->salesman;
        $adress = isset($salesman->store->adress) ? $salesman->store->adress : '';
        if($store = $salesman->store){
            return view('accont.stores', compact('store','salesman', 'adress'));
        }
        return view('accont.stores',compact('salesman'));
    }


    public function store(Request $request){
        if(Gate::denies('vendedor')){
            return  redirect()->route('accont.home');
        }
        $validate = [
            'name' => 'required|unique:stores',
            'type_salesman' => 'required',
            'logo_file' => 'required|image|mimes:png,jpg,jpeg',
            'about' => 'required|max:500'
        ];
        if($request->type_salesman === 'J'){
            $validate['cnpj'] = 'required|cnpj_mascara|unique:stores';
            $validate['social_name'] = 'required';
            $validate['fantasy_name'] = 'required';
        }
        $this->validate($request, $validate, ['name.required' => 'O nome é obrigatório', 'name.unique' => 'Esse nome de loja já está sendo utilizado',
            'type_salesman.required' => 'O tipo de pessoa é obrigatório', 'logo_file.required' => 'A arquivo de logo é obrigatório',
            'logo_file.image' => 'O arquivo de logo não é do tipo imagem', 'logo_file.mimes' => 'Tipo de imagem inválido (PNG, JPG, JPEG).',
            'about.required' => 'O sobre a loja é obrigatório', 'about.max' => 'O máximo de 500 caracteres', 'exchange_policy.required' => 'A política de troca é obrigatório',
            'exchange_policy.max' => 'O máximo de 500 caracteres', 'freight_policy.max' => 'O máximo de 500 caracteres',
            'cnpj.required' => 'O cnpj é obrigatório', 'cnpj.cnpj_mascara' => 'CNPJ inválido', 'cnpj.unique' => 'CNPJ já utilizado',
            'social_name.required' => 'A Razão Social é obrigatório', 'fantasy_name.required' => 'Nome à Fantasia é obrigatório']);

        $dados = $request->except('logo_file');
        $user = Auth::user();
        $dados['salesman_id'] = $user->salesman->id;
        if($store = $this->repo->store($dados)){
            $dados['logo_file'] = $this->upload($request->logo_file,'img/loja','L'.$store->id.'V'.$dados['salesman_id'].'U'.$user->id);
            $address = $user->addresses->where('master',1)->first();
            $address->fill(['store_id' => $store->id])->save();
            $this->repo->update($dados,$store->id);
            flash('Loja criada com sucesso!', 'accept');
            return redirect()->route('accont.salesman.stores');
        }
        flash('Erro ao criar a loja!', 'error');
        return redirect()->route('accont.salesman.stores');

    }

    public function update(Request $request){
        $user = Auth::user();
        $store = $user->salesman->store;
        if(Gate::denies('store_access', $store)){
            return  redirect()->route('accont.home');
        }
        $validate = [
            'name' => 'required|unique:stores,name,'.$store->id,
            'type_salesman' => 'required',
            'logo_file' => 'image|mimes:png,jpg,jpeg',
            'about' => 'required|max:500',
            'exchange_policy' => 'required|max:500',
            'freight_policy' => 'max:500'
        ];
        if($request->type_salesman === 'J'){
            $validate['cnpj'] = 'required|cnpj_mascara|unique:stores,cnpj,'.$store->id;
            $validate['social_name'] = 'required';
            $validate['fantasy_name'] = 'required';
        }
        $this->validate($request, $validate, ['name.required' => 'O nome é obrigatório', 'name.unique' => 'Esse nome de loja já está sendo utilizado',
            'type_salesman.required' => 'O tipo de pessoa é obrigatório', 'logo_file.required' => 'A arquivo de logo é obrigatório',
            'logo_file.image' => 'O arquivo de logo não é do tipo imagem', 'logo_file.mimes' => 'Tipo de imagem inválido (PNG, JPG, JPEG).',
            'about.required' => 'O sobre a loja é obrigatório', 'about.max' => 'O máximo de 500 caracteres', 'exchange_policy.required' => 'A política de troca é obrigatório',
            'exchange_policy.max' => 'O máximo de 500 caracteres', 'freight_policy.max' => 'O máximo de 500 caracteres',
            'cnpj.required' => 'O cnpj é obrigatório', 'cnpj.cnpj_mascara' => 'CNPJ inválido', 'cnpj.unique' => 'CNPJ já utilizado',
            'social_name.required' => 'A Razão Social é obrigatório', 'fantasy_name.required' => 'Nome à Fantasia é obrigatório']);

        $dados = $request->except('logo_file');
        $dados['cpf'] = isset($request->cpf) ? $request->cpf : '';
        if($request->hasFile('logo_file')){
            if($islogo = file_exists(storage_path() . '/img/loja/'. $store->logo_file)){
                Storage::delete('img/loja/'.$store->logo_file);
            }
            $dados['logo_file'] = $this->upload($request->logo_file,'img/loja','L'.$store->id.'V'.$user->salesman->id.'U'.$user->id);
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

    public function blocked(){
        $user = Auth::user();
        if($store = $user->salesman->store){
            if($store->active === 1){
                $store->fill(['active' => 0])->save();
            }else{
                $store->fill(['active' => 1])->save();
            }
            return response()->json(['status'=>true,'lock'=>$store->active],200);

        }
        return response()->json(['msg'=>'Erro ao bloquear a loja'],500);
    }

    public function search(Request $request)
    {
        $page = Input::get('page') ? Input::get('page') : 1 ;
        $result = $this->repo->search($request->name, $this->columns, $this->with, ['name'=>'ASC'], $limit = 15, $page);
        if($request->ajax()){
            return view('accont.presearchstore', compact('result'));
        }
        return view('accont.searchstore', compact('result'));
    }

}