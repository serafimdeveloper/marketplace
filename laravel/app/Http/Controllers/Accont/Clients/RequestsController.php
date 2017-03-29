<?php
namespace App\Http\Controllers\Accont\Clients;

use App\Http\Controllers\AbstractController;
use App\Http\Requests\Request;
use App\Repositories\Accont\RequestsRepository;
use Auth;
use Correios;
use Illuminate\Support\Facades\Gate;

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
        $this->status_request();
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $requests = $this->repo->all($this->columns, $this->with, ['user_id' => $user->id], ['id' => 'DESC'], 5, $page);
        return view('accont.requests', compact('requests'));
    }

    public function show($id)
    {
        if ($request = $this->repo->get($id, $this->columns, $this->with)) {
            $user = Auth::User();
            if (Gate::allows('vendedor', $user)) {
                if ($store = $user->salesman->store) {
                    if ($store->id === $request->store->id) {
                        return redirect()->route('accont.salesman.sale_info', ['id' => $request->id]);
                    }
                }
            }

            if ($request->user->id === $user->id || Gate::allows('admin', $user)) {
                $type = ['type' => 'request', 'id' => $request->id];
                $request = ($request ? $request : false);
                if (!$request) {
                    return redirect()->route('accont.home');
                } else {
                    $rastreamento = Correios::rastrear($request->tracking_code);
                    if($rastreamento[0]['status'] === 'Entrega Efetuada'){
                        $request->fill(['request_status_id' => 5])->save();
                    }
                    return view('accont.request_info', compact('request', 'user', 'type', 'rastreamento'));
                }
            }
        }
        return redirect()->route('accont.home');
    }

    private function status_request(){
        $user = Auth::user();
        $req_freights = $user->requests->where('request_status_id',4);
        $req_freights->each(function($request){
            $status_freigth = Correios::rastrear($request->zip_code);
            if($status_freigth[0]['status'] === 'Entrega Efetuada'){
                $request->fill(['request_status_id' => 5])->save();
            }
            return $request;
        });
    }
}