<?php

namespace App\Http\Controllers\Account\Clients;

use App\Http\Controllers\AbstractController;
use App\Http\Requests\Request;
use App\Model\RequestStatus;
use App\Repositories\Account\RequestsRepository;
use App\Services\MoipServices;
use App\Services\CorreiosService as Correios;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RequestsController extends AbstractController {
    protected $with = ['store', 'user', 'request_status', 'products', 'type_freight'];

    public function repo(){
        return RequestsRepository::class;
    }

    public function index(){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
        $req = Request::capture();
        $request_status = RequestStatus::pluck('description', 'id');
        $selected_status = (isset($req->all()['status']) ? (int) $req->all()['status'] : null);
        $user = Auth::User();
        //$this->status_request();
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $where = ($selected_status ? [['user_id', '=', $user->id], ['request_status_id', '=', $selected_status]] : ['user_id' => $user->id]);
        $requests = $this->repo->withTrashed()->all($this->columns, $this->with, $where, ['id' => 'DESC'], 10, $page);
//        dd($selected_status);
        return view('account.requests', compact('requests', 'request_status', 'selected_status'));
    }

    public function show($id){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
        if($request = $this->repo->withTrashed()->get($id, $this->columns, $this->with)){
            $user = Auth::User();
            $address['receiver'] = json_decode($request->address_receiver);
            $address['sender'] = json_decode($request->address_sender);
//            if(Gate::allows('vendedor', $user)){
//                if($store = $user->seller->store){
//                    if($store->id === $request->store->id){
//                        return redirect()->route('account.seller.sale_info', ['id' => $request->id]);
//                    }
//                }
//            }
            if($request->user->id === $user->id || Gate::allows('admin', $user)){
                $request = ($request ? $request : false);
                if($request){
                    $type = ['type' => 'request', 'id' => $request->id];
                    $request->update(['visualized_user'=>1]);
                    return view('account.request_info', compact('request', 'user', 'type', 'address'));
                }
            }
        }
        return redirect()->route('account.home');
    }

    private function status_request(){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
        $user = Auth::user();
        $req_freights = $user->requests->where('request_status_id', 4);
        $correios = $this->app->make(Correios::class);
        $req_freights->each(function($request) use($correios) {
            $status_freigth = $correios->rastrear($request->tracking_code);
            if($status_freigth[0]['status'] === 'Entrega Efetuada'){
                $request->fill(['request_status_id' => 5])->save();
            }
            return $request;
        });
    }
}