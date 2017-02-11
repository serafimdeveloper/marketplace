<?php
namespace App\Http\Controllers\Accont;

use App\Http\Controllers\AbstractController;
use App\Repositories\Accont\MessagesRepository;
use Auth;

class MessagesController extends AbstractController
{
    protected $with = [];

    public function repo()
    {
        return MessagesRepository::class;
    }

    public function index()
    {
        //        $collection = $this->user->messages->sortByDesc(function($message, $key){
//            return $message->create_at;
//        });
//
//        $messages = $collection->values()->all();
        $user = Auth::user();
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $messages = $this->repo->all($this->columns, $this->with, ['recipient_id' => $user->id], ['id' => 'DESC'], 5, $page);
        $messages = ($messages->first() ? $messages : false);
        return view('accont.messages', compact('messages'));
    }

    public function show($id)
    {
        $user = Auth::User();
        $message = $this->repo->all($this->columns, $this->with, ['id' => $id, 'recipient_id' => $user->id])->first();
        return view('accont.message_info', compact('message'));
    }
}