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

    public function index(){
        $user = Auth::User();

        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);

        $requests = $this->repo->all($this->columns,$this->with,['user_id'=>$user->id], ['id' => 'DESC'], 5, $page);

        $requests = ($requests->first() ? $requests : false);
        return view('accont.requests', compact('requests'));
    }

    public function show($id){
        $user = Auth::User();
        $request = $this->repo->all($this->columns,$this->with,['id' => $id, 'user_id'=>$user->id])->first();
//        dd($request);

        $request = ($request ? $request : false);

        if(!$request){
            return redirect()->route('accont.home');
        }else{
            return view('accont.request_info', compact('request', 'user'));
        }
    }

    public function comments(Request $req, $id){
        $this->validate($req,['message'=>'required|min:10|max:500']);
        $user = Auth::user();
       if($request = $this->repo->get($id)){
           $dados = [
               'sender_id' => $user->id,
               'sender_type' => get_class($user),
               'recipient_type' => $request->store_id,
               'recipient_type' => get_class($request->store),
               'request_id' => $request->id,
               'title' => 'Comentário de '.$user->name.' sobre o pedido '.$request->key,
               'content' => $req->message,
           ];
       }

    }


}