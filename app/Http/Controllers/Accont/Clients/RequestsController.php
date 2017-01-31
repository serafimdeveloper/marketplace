<?php
namespace App\Http\Controllers\Accont\Clients;

use App\Http\Controllers\AbstractController;
use App\Repositories\Accont\RequestsRepository;
use Auth;

class RequestsController extends AbstractController
{
    public function repo()
    {
<<<<<<< HEAD
       return RequestsRepository::class;
=======
        return RequestsRepository::class;
>>>>>>> bce18fe29dae55b5652124c4ac0127862a822b3e
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