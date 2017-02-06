<?php

namespace App\Http\Controllers\Accont;

use App\Http\Controllers\Controller;
use Auth;

class MessagesController extends Controller
{
    private $user;
    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index(){
        $collection = $this->user->messages->sortByDesc(function($message, $key){
            return $message->create_at;
        });
        $messages = $collection->values()->all();
        return view('accont.message', compact('messages'));
    }

}