<?php
namespace App\Http\Controllers\Accont\Clients;

use App\Http\Controllers\Controller;
use App\Repositories\Accont\RequestsRepository;
use Auth;

class RequestsController extends Controller
{
    protected $repo, $user;

    public function __construct(RequestsRepository $repo)
    {
        $this->repo = $repo;
        $this->user = Auth::User();
    }

    public function index(){
        $requests = $this->repo->all(null,null,['user_id'=>$this->user->id]);
        return view('accont.requests', compact('requests'));
    }

    public function show($id){
        $request = $this->repo->get($id);
        return view('accont.request_info', compact('request'));
    }

}