<?php

namespace App\Http\Controllers\Accont;

use App\Http\Controllers\AbstractController;
use App\Model\Product;
use App\Model\Store;
use App\Model\Request as Req;
use App\Model\User;
use App\Repositories\Accont\MessagesRepository;
use Illuminate\Container\Container as App;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

class MessagesController extends AbstractController {
    protected $with = ['sender', 'recipient', 'request', 'product', 'message'];
    protected $user, $product, $req;

    public function __construct(App $app, User $user, Product $product, Req $req){
        parent::__construct($app);
        $this->user = $user;
        $this->product = $product;
        $this->req = $req;
    }

    public function repo(){
        return MessagesRepository::class;
    }

    public function index($type, $box = 'received'){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        if($box !== 'received' && $box !== 'send'){
            return redirect()->route('accont.home');
        }
        $data = ['type' => $type, 'box' => $box];
        if($type == 'user'){
            $messages = $this->getAllMessages($data);
            return view('accont.messages', compact('messages', 'type', 'box'));
        }elseif($type == 'store'){
            if($store = Auth::user()->salesman->store){
                $messages = $this->getAllMessages($data);
                return view('accont.messages', compact('messages', 'type', 'box'));
            }
        }
        flash('Precisa possuir uma loja para ver as mensagens', 'warning');

        return redirect()->route('accont.salesman.stores');
    }

    public function show($box, $id){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        $user = Auth::user();
        if($message = $this->repo->get($id)){
            if(Gate::allows('read_message', [$message, $box])){
                $this->read_type($user, $message, $box);
                $messages = $this->repo->getMessages($message, $this->with, ['created_at' => 'ASC']);
                $eu = $user->name;

                return view('accont.message_info', compact('messages', 'message', 'box', 'eu'));
            }
        }
        flash('Mensagem não encontrada', 'error');

        return redirect()->intended('accont');
    }

    public function comments(Request $request, $type, $id){
        $this->validate($request, ['message' => 'required|min:5:max:500'], ['message.required' => 'A messagem é obrigatório', 'message.min' => 'A quantidade mínima de caracteres é 5', 'message.max' => 'A quantidade máxima é de 500 caracteres']);
        $user = Auth::user();
        $dados = ['sender_id' => $user->id, 'sender_type' => get_class($user), 'content' => $request->message];
        if($type === "request"){
            if($req = $this->req->find($id)){
                $dados['request_id'] = $id;
                $dados['title'] = 'Comentário de ' . $user->name . ' sobre o pedido ' . $req->key;
                $store = $req->store;
                $dados['recipient_id'] = $store->id;
                $dados['recipient_type'] = get_class($store);
            }else{
                flash('Não foi possivel enviar a mensagem, porque o pedido não existe!', 'error');
                return redirect()->back();
            }
        }else{
            if($product = $this->product->find($id)){
                $dados['product_id'] = $id;
                $dados['title'] = 'Comentário de ' . $user->name . ' sobre o produto ' . $product->name;
                $store = $product->store;
                $dados['recipient_id'] = $store->id;
                $dados['recipient_type'] = get_class($store);
            }else{
                flash('Não foi possivel enviar a mensagem, porque o produto não existe!', 'error');
                return redirect()->back();
            }
        }
        if($message = $this->repo->store($dados)){
            $data = ['email' => $store->salesman->user->email, 'name' => $store->name, 'id' => $message->id, 'message_type' => 'store'];
            send_mail('emails.received_message', $data, 'Você recebeu uma mensagem de '.$user->name);
            $this->repo->update(['message_id' => $message->id], $message->id);
            flash('Mensagem enviada com sucesso!', 'accept');

            return redirect()->back();
        }
        flash('Não foi possivel enviar a mensagem', 'error');

        return redirect()->back();
    }

    public function answer(Request $request, $box, $id){
        $this->validate($request, ['message' => 'required|min:5:max:500'], ['message.required' => 'A messagem é obrigatório', 'message.min' => 'A quantidade mínima de caracteres é 5', 'message.max' => 'A quantidade máxima é de 500 caracteres']);
        if($model = $this->repo->get($id, $this->columns, $this->with)){
            $dados = ['sender_id' => $model->recipient_id, 'sender_type' => get_class($model->recipient), 'recipient_id' => $model->sender_id, 'recipient_type' => get_class($model->sender), 'message_type_id' => $model->message_type_id, 'request_id' => $model->request_id, 'product_id' => $model->product_id, 'message_id' => $model->message_id, 'title' => $model->title, 'content' => $request->message];
            $this->repo->filter_messages($request->message);
            if($message = $this->repo->store($dados)){
                if(($model->sender instanceof Store && $box === 'received') || ($model->recipient instanceof Store && $box === 'send')){
                    $recipient = ($box === 'received') ? $model->sender : $model->recipient;
                    $sender    = ($box === 'received') ? $model->recipient : $model->sender;
                    $data = ['email' => $recipient->salesman->user->email, 'name' => $recipient->name, 'id' => $message->id, 'message_type' => 'store'];
                    send_mail('emails.received_message', $data, 'Você recebeu uma mensagem de '.$sender->name);
                }
                flash('Mensagem enviada com sucesso!', 'accept');
                return redirect()->back();
            }
        }
        flash('Não foi possivel enviar a mensagem', 'error');
        return redirect()->back();
    }

    public function destroy(Request $request){
        if($messages = $this->repo->getByIds($request->ids)){
            $messages->each(function($message){
                $message->update(['desactive' => 1]);
            });
            return json_encode(['status' => true]);
        }

        return json_encode(['msg' => 'erro ao apagar as mensagens'], 500);
    }

    private function getAllMessages($data){
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $messages = $this->repo->getAllMessages($data, $this->columns, $this->with, ['id' => 'DESC'], 5, $page);
        if($data['box'] === 'received'){
            $messages = $messages->groupBy(function($item, $key){
                return $item['message_id'];
            });
            return new LengthAwarePaginator($messages,$messages->count(),5,$page);
        }
        return $messages;
    }

    private function read_type($user, $message, $box){
        if($box === 'received'){
            $recipient = app($message->recipient_type);
            if($recipient instanceof User){
                if($message->recipient_id === $user->id){
                    $message->update(['status' => 'readed']);
                }
            }elseif($recipient instanceof Store){
                if($message->recipient_id === $user->salesman->store->id){
                    $message->update(['status' => 'readed']);
                }
            }
        }
    }
}