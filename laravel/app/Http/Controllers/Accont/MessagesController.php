<?php
namespace App\Http\Controllers\Accont;

use App\Http\Controllers\AbstractController;
use App\Model\User;
use App\Repositories\Accont\MessagesRepository;
use Illuminate\Container\Container as App;
use Auth;

class MessagesController extends AbstractController
{
    protected $with = ['sender','recipient','message_type','request','product','message'];
    protected $user;
    public function __construct(App $app, User $user)
    {
        parent::__construct($app);
        $this->user = $user;
    }

    public function repo()
    {
        return MessagesRepository::class;
    }

    public function index()
    {
        $user = Auth::user();
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $messages = $this->repo->all($this->columns, $this->with, ['recipient_id' => $user->id], ['id' => 'DESC'], 5, $page);
        $messages = ($messages->first() ? $messages : false);

        return view('accont.messages', compact('messages'));
    }

    public function show($id)
    {
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $messages = $this->repo->getMessages($id,$this->with,['created_at' => 'DESC'],5,$page);
        $message = $messages->first();
        if($message->status === 'received'){
            $message->update(['status' => 'readed']);
        }
        return view('accont.message_info', compact('messages','message'));
    }

    public function answer(MessagesRepository $messagesRepository){

    }

    public function destroy()
    {
        $user = Auth::user();

        dd($user);

        return json_encode(['status' => true]);
    }
}