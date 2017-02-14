<?php
namespace App\Http\Controllers\Accont;

use App\Http\Controllers\AbstractController;
use App\Model\Store;
use App\Model\User;
use App\Repositories\Accont\MessagesRepository;
use Illuminate\Container\Container as App;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

    public function index($type)
    {
        if($type == 'user'){
            $messages = $this->getAllMessages($type);
            return view('accont.messages', compact('messages'));
        }else if($type == 'store'){
            if ($store = Auth::user()->salesman->store) {
                $messages = $this->getAllMessages($type);
                return view('accont.messages', compact('messages'));
            }
        }
        flash('Precisa possuir uma loja para ver as mensagens', 'warning');
        return redirect()->route('accont.salesman.stores');
    }

    public function show($id)
    {
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        if($message = $this->repo->get($id)){
            if(Gate::allows('read_message', $message)){
                $messages = $this->repo->getMessages($message,$this->with,['created_at' => 'ASC'],5,$page);
                if($message->status === 'received'){
                    $message->update(['status' => 'readed']);
                }
                return view('accont.message_info', compact('messages','message'));
            }
            flash('Mensagem não encontrada', 'error');
            return redirect()->back();
        }

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
            return redirect()->back();
        }
        flash('Não foi possivel enviar a mensagem', 'error');
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        if($messages = $this->repo->getByIds($request->ids)) {
            $messages->each(function ($message) {
                $message->fill(['desactive' => 1])->save();
            });
            return json_encode(['status' => true]);
        }
        return json_encode(['msg'=>'erro ao apagar as mensagens'],500);
    }

    private function getAllMessages($type){
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $messages = $this->repo->getAllMessages($type,$this->columns, $this->with, ['id' => 'DESC'], 5, $page);
        $messages = ($messages->first() ? $messages : false);
        return $messages;
    }
}