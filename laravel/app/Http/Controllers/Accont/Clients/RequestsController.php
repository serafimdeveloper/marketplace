<?php

namespace App\Http\Controllers\Accont\Clients;

use App\Http\Controllers\AbstractController;
use App\Http\Requests\Request;
use App\Model\RequestStatus;
use App\Repositories\Accont\RequestsRepository;
use App\Services\MoipServices;
use Auth;
use Correios;
use Illuminate\Support\Facades\Gate;

class RequestsController extends AbstractController {
    protected $with = ['store', 'user', 'adress', 'requeststatus', 'products', 'freight'];

    public function repo(){
        return RequestsRepository::class;
    }

    public function index(){
        $req = Request::capture();
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        $request_status = RequestStatus::pluck('description', 'id');
        $selected_status = (isset($req->all()['status']) ? (int) $req->all()['status'] : null);
        $user = Auth::User();
        $this->status_request();
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $where = ($selected_status ? [['user_id', '=', $user->id], ['request_status_id', '=', $selected_status]] : ['user_id' => $user->id]);
        $requests = $this->repo->all($this->columns, $this->with, $where, ['id' => 'DESC'], 10, $page);
//        dd($selected_status);
        return view('accont.requests', compact('requests', 'request_status', 'selected_status'));
    }

    public function show($id, MoipServices $moip){
//        $moip->checkStatusInstruction($id);
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        if($request = $this->repo->get($id, $this->columns, $this->with)){
            $user = Auth::User();
            if(Gate::allows('vendedor', $user)){
                if($store = $user->salesman->store){
                    if($store->id === $request->store->id){
                        return redirect()->route('accont.salesman.sale_info', ['id' => $request->id]);
                    }
                }
            }
            if($request->user->id === $user->id || Gate::allows('admin', $user)){
                $request = ($request ? $request : false);
                if($request){
                    $type = ['type' => 'request', 'id' => $request->id];
//                    PN769221969BR
                    $request->update(['visualized_user'=>1]);
                    $rastreamento = track_object($request->tracking_code, $id);
                    return view('accont.request_info', compact('request', 'user', 'type', 'rastreamento'));
                }
            }
        }

        return redirect()->route('accont.home');
    }

    private function status_request(){
        $user = Auth::user();
        $req_freights = $user->requests->where('request_status_id', 4);
        $req_freights->each(function($request){
            $status_freigth = Correios::rastrear($request->zip_code);
            if($status_freigth[0]['status'] === 'Entrega Efetuada'){
                $request->fill(['request_status_id' => 5])->save();
            }

            return $request;
        });
    }
}