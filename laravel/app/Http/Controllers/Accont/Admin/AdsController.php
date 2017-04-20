<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 12/04/2017
 * Time: 20:44
 */

namespace App\Http\Controllers\Accont\Admin;


use App\Model\Store;
use App\Repositories\Accont\StoresRepository;
use App\Repositories\AdRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdsController extends  AbstractAdminController
{
    protected  $store_repo;

    public function __construct(AdRepository $repo, StoresRepository $store_repo)
    {
        $this->repo = $repo;
        $this->store_repo = $store_repo;
    }

    public function index(Request $request){
        if(Gate::denies('admin')){
            return redirect()->route('accont.home');
        }
        $this->ordy = ['name' => 'ASC'];
        $this->with = ['store'];
        $this->title = 'Banners';
        $data = $this->search($request, 'banners');
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }

    public function create(){
        $stores = $this->store_repo->all()->pluck('name','id');
        return view('layouts.parties.alert_banner', compact('stores'));
    }



    public function store(Request $request){
        if(Gate::denies('admin')){
            return redirect()->route('accont.home');
        }
        $this->validate($request,['store_id' => 'required','description' => 'required|max:50','date_start' => 'required','date_end' => 'required'],
            ['store_id.required' => 'A loja é obrigatório', 'description.required' => 'A descrição é obrigatória', 'description.max' => 'Máximo de 50 caracteres',
            'date_start.required' => 'A data inicial é obrigatório', 'date_end.required' => 'A data final é obrigatório']);

        $data = $request->all();
        $date = new \DateTime($request->date_start);
        $data['date_start'] = $date->format('Y-m-d H:i:s');
        $date = new \DateTime($request->date_end);
        $data['date_end'] = $date->format('Y-m-d H:i:s');

        unset($data['_token']);
        if($ads = $this->repo->store($data)){
            flash('Banner agendado com sucesso', 'accept');
            return redirect()->back();
        }
        flash('Erro ao agendar banner', 'error');
        return redirect()->back();
    }

    public function edit($id){
        if(Gate::denies('admin')){
            return redirect()->route('accont.home');
        }
        if($result = $this->getByRepoId($id)){
            $stores = $this->store_repo->all()->pluck('name','id');
            return view('layouts.parties.alert_banner', compact('result', 'stores'));
        }
        return response()->json(['msg' => 'Erro ao encontrar o vendedor'],404);
    }

    public function update(Request $request, $id){
        if(Gate::denies('admin')){
            return redirect()->route('accont.home');
        }
        $this->validate($request,['store_id' => 'required','description' => 'required|max:50','date_start' => 'required','date_end' => 'required'],
            ['store_id.required' => 'A loja é obrigatório', 'description.required' => 'A descrição é obrigatória', 'description.max' => 'Máximo de 50 caracteres',
                'date_start.required' => 'A data inicial é obrigatório', 'date_end.required' => 'A data final é obrigatório']);

        $data = $request->all();
        $date = new \DateTime($request->date_start);
        $data['date_start'] = $date->format('Y-m-d H:i:s');
        $date = new \DateTime($request->date_end);
        $data['date_end'] = $date->format('Y-m-d H:i:s');

        if($ads = $this->repo->update($request->all(), $id)){
            return response()->json(['msg' => 'Banner agendado com sucesso',201]);
        }
        return response()->json(['msg' => 'Erro ao agendar o banner'],500);
    }

    public function destroy($id){
        if(Gate::denies('admin')){
            return redirect()->route('accont.home');
        }
        if($this->repo->delete($id)){
            return response()->json(['status' => true],200);
        }
        return response()->json(['msg'=> 'Erro ao apagar o agendamento do banner'],500);
    }


}