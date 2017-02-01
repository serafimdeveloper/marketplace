<?php
namespace App\Http\Controllers\Accont\Clients;

use App\Http\Controllers\AbstractController;
use App\Repositories\Accont\RequestsRepository;
use Auth;

class RequestsController extends AbstractController
{
    public function repo()
    {
       return RequestsRepository::class;
    }

    public function index(){
        $user = Auth::User();
        $requests = $this->repo->all($this->columns,$this->with,['user_id'=>$user->id]);
        return view('accont.requests', compact('requests'));
    }

    public function show($id){
        #$request = $this->repo->get($id);
        return view('accont.request_info');
    }


}