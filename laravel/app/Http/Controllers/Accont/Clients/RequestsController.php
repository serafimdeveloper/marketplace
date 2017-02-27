<?php
namespace App\Http\Controllers\Accont\Clients;

use App\Http\Controllers\AbstractController;
use App\Http\Requests\Request;
use App\Repositories\Accont\RequestsRepository;
use Auth;

class RequestsController extends AbstractController
{
    protected $with = ['store', 'user', 'adress', 'requeststatus', 'products', 'freight'];

    public function repo()
    {
        return RequestsRepository::class;
    }

    public function index()
    {
        $user = Auth::User();
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $requests = $this->repo->all($this->columns, $this->with, ['user_id' => $user->id], ['id' => 'DESC'], 5, $page);
        $requests = ($requests->first() ? $requests : false);
        return view('accont.requests', compact('requests'));
    }

    public function show($id)
    {
        $user = Auth::User();
        $request = $this->repo->get($id, $this->columns, $this->with);
        if((($request->store->id == Auth::user()->salesman->store->id)) || ($request->user_id == $user->id)){
            $type = ['type' => 'request', 'id' => $request->id];
            $request = ($request ? $request : false);
            if(!$request){
                return redirect()->route('accont.home');
            }else{
                return view('accont.request_info', compact('request', 'user', 'type'));
            }
        }
        return redirect()->route('accont.home');
    }
}