<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 24/01/2017
 * Time: 18:07
 */

namespace App\Http\Controllers\Account;

use App\Http\Controllers\AbstractController;
use App\Repositories\Account\StoresRepository;
use Illuminate\Container\Container as App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class StoresController extends AbstractController
{

    public function __construct(App $app)
    {
        parent::__construct($app);
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
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
           return  redirect()->route('account.home');
        }
        $seller = Auth::user()->seller;
        $address = isset($seller->store->address) ? $seller->store->address : '';
        if($store = $seller->store){
            return view('account.stores', compact('store','seller', 'address'));
        }
        return view('account.stores',compact('seller'));
    }


    public function store(Request $request){
        if(Gate::denies('vendedor')){
            return  redirect()->route('account.home');
        }
        $validate = [
            'name' => 'required|unique:stores',
            'type_seller' => 'required',
            'logo_file' => 'required|image|mimes:png,jpg,jpeg',
            'about' => 'required'
        ];
        if($request->type_seller === 'J'){
            $validate['cnpj'] = 'required|cnpj_mascara|unique:stores';
            $validate['social_name'] = 'required';
            $validate['fantasy_name'] = 'required';
        }
        $this->validate($request, $validate, ['name.required' => 'O nome é obrigatório', 'name.unique' => 'Esse nome de loja já está sendo utilizado',
            'type_seller.required' => 'O tipo de pessoa é obrigatório', 'logo_file.required' => 'A arquivo de logo é obrigatório',
            'logo_file.image' => 'O arquivo de logo não é do tipo imagem', 'logo_file.mimes' => 'Tipo de imagem inválido (PNG, JPG, JPEG).',
            'about.required' => 'O sobre a loja é obrigatório', 'about.max' => 'O máximo de 500 caracteres', 'exchange_policy.required' => 'A política de troca é obrigatório',
            'exchange_policy.max' => 'O máximo de 500 caracteres', 'freight_policy.max' => 'O máximo de 500 caracteres',
            'cnpj.required' => 'O cnpj é obrigatório', 'cnpj.cnpj_mascara' => 'CNPJ inválido', 'cnpj.unique' => 'CNPJ já utilizado',
            'social_name.required' => 'A Razão Social é obrigatório', 'fantasy_name.required' => 'Nome à Fantasia é obrigatório']);

        $dados = $request->except('logo_file');
        $user = Auth::user();
        $dados['seller_id'] = $user->seller->id;
        if($store = $this->repo->store($dados)){
            $dados['logo_file'] = $this->upload($request->logo_file,'img/loja','L'.$store->id.'V'.$dados['seller_id'].'U'.$user->id);
            $address = $user->addresses->where('master',1)->first();
            $address->fill(['store_id' => $store->id])->save();
            $this->repo->update($dados,$store->id);
            flash('Loja criada com sucesso!', 'accept');
            return redirect()->route('account.seller.stores');
        }
        flash('Erro ao criar a loja!', 'error');
        return redirect()->route('account.seller.stores');

    }

    public function update(Request $request){
        $user = Auth::user();
        $store = $user->seller->store;
        if(Gate::denies('store_access', $store)){
            return  redirect()->route('account.home');
        }
        $validate = [
            'name' => 'required|unique:stores,name,'.$store->id,
            'type_seller' => 'required',
            'logo_file' => 'image|mimes:png,jpg,jpeg',
            'about' => 'required',
            'exchange_policy' => 'required',
        ];
        if($request->type_seller === 'J'){
            $validate['cnpj'] = 'required|cnpj_mascara|unique:stores,cnpj,'.$store->id;
            $validate['social_name'] = 'required';
            $validate['fantasy_name'] = 'required';
        }
        $this->validate($request, $validate, ['name.required' => 'O nome é obrigatório', 'name.unique' => 'Esse nome de loja já está sendo utilizado',
            'type_seller.required' => 'O tipo de pessoa é obrigatório', 'logo_file.required' => 'A arquivo de logo é obrigatório',
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
            $dados['logo_file'] = $this->upload($request->logo_file,'img/loja','L'.$store->id.'V'.$user->seller->id.'U'.$user->id);
        }
        if($this->repo->update($dados,$store->id)){
            if(!$store->address){
                $address = $user->addresses->where('master',1)->first();
                $address->fill(['store_id' => $store->id])->save();
            }
            flash('Loja atualizada com sucesso!', 'accept');
            return redirect()->route('account.seller.stores');
        }
        flash('Erro ao atualizar a loja!', 'error');
        return redirect()->route('account.seller.stores');
    }

    public function show($slug){
        $store = $this->repo->bySlug($slug);
    }

    public function blocked(){
        $user = Auth::user();
        if($store = $user->seller->store){
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
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
        $page = Input::get('page') ? Input::get('page') : 1 ;
        $result = $this->repo->search($request->name, $this->columns, $this->with, ['name'=>'ASC'], $limit = 15, $page);
        if($request->ajax()){
            return view('account.presearchstore', compact('result'));
        }
        return view('account.searchstore', compact('result'));
    }

}