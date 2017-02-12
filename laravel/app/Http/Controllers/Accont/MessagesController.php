<?php
namespace App\Http\Controllers\Accont;

use App\Http\Controllers\AbstractController;
use App\Model\User;
use App\Repositories\Accont\MessagesRepository;
use Illuminate\Container\Container as App;
use Auth;
use Illuminate\Http\Request;

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
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $messages = $this->repo->getAllMessages('user',$this->columns, $this->with, ['id' => 'DESC'], 5, $page);
        $messages = ($messages->first() ? $messages : false);

        return view('accont.messages', compact('messages'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $messages = $this->repo->getMessages($id,$this->with,['created_at' => 'DESC'],5,$page);
        $message = $messages->where('recipient_id', $user->id)->first();
        if($message->status === 'received'){
            $message->update(['status' => 'readed']);
        }
        return view('accont.message_info', compact('messages','message'));
    }

    public function answer(Request $request,$id){
        $this->validate($request, [
            'message'=>'required|min:5:max:500'
        ]);
        $model = $this->repo->get($id,$this->columns,$this->with);

        $dados = ['sender_id' => $model->recipient_id, 'sender_type' => get_class($model->recipient),
                 'recipient_id' => $model->sender_id, 'recipient_type' => get_class($model->sender),
                 'message_type_id' => $model->message_type_id, 'request_id' => $model->request_id,
                 'product_id' => $model->product_id, 'message_id' => $model->message_id,
                 'title' => $model->title, 'content' => $request->message];
        if($message = $this->repo->store($dados)) {
            flash('Mensagem enviada com sucesso!', 'accept');
            return redirect()->route('accont.messages');
        }
        flash('Não foi possivel enviar a mensagem', 'error');
        return redirect()->route('accont.message_info');
    }

    public function destroy()
    {
        $user = Auth::user();

        dd($user);

        return json_encode(['status' => true]);
    }
}