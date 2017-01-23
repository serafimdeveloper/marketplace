<?php
namespace App\Http\Controllers\Accont\Clients;

use App\Http\Controllers\Controller;
use Auth;

class RequestsController extends Controller
{

    public function index(){
        $user = Auth::User();
        $collection = $user->requests->sortByDesc(function($request, $key){
            return $request->create_at;
        });
        $requests = $collection->values()->all();
        return view('accont.requests', compact('requests'));
    }

    public function show($id){
        $user = Auth::User();
        $request = $user->requests->find($id);
        return view('accont.request_info', compact('request'));
    }

}