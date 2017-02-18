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
use Illuminate\Support\Facades\Gate;

class MessagesController extends AbstractController
{
    protected $with = ['sender','recipient','request','product','message'];
    protected $user, $product, $req;
    public function __construct(App $app, User $user, Product $product,Req $req)
    {
        parent::__construct($app);
        $this->user = $user;
        $this->product = $user;
        $this->req = $req;
    }

    public function repo()
    {
        return MessagesRepository::class;
    }

    public function index($type, $box = 'received')
    {
        if($box !== 'received' && $box !== 'send'){
            return redirect()->route('accont.home');
        }
        $data = ['type' => $type, 'box' => $box];
        if($type == 'user'){
            $messages = $this->getAllMessages($data);
            return view('accont.messages', compact('messages', 'type', 'box'));
        }else if($type == 'store'){
            if ($store = Auth::user()->salesman->store) {
                $messages = $this->getAllMessages($data);
                return view('accont.messages', compact('messages', 'type', 'box'));
            }
        }
        flash('Precisa possuir uma loja para ver as mensagens', 'warning');
        return redirect()->route('accont.salesman.stores');
    }

    public function show($box, $id)
    {
        $user = Auth::user();
        if($message = $this->repo->get($id)){
            $message->update(['status' => 'readed']);
            if($message->message_id){
                $message = $this->repo->get($message->message_id);
            }
            if(Gate::allows('read_message', [$message, $box])){
                $messages = $this->repo->getMessages($message,$this->with,['created_at' => 'ASC']);
                if($message->status === 'received'){
                    $message->update(['status' => 'readed']);
                }
                $eu = $user->name;
                return view('accont.message_info', compact('messages','message', 'box', 'eu'));
            }
            flash('Mensagem não encontrada', 'error');
            return redirect()->back();
        }
    }

    public function comments(Request $request, $type, $id){
        $this->validate($request, [
            'message'=>'required|min:5:max:500'
        ]);
        $user = Auth::user();
        $dados = ['sender_id' => $user->id, 'sender_type' => get_class($user), 'content'=>$request->message];
        if($type === "request"){
            if($req = $this->req->find($id)) {
                $dados['request_id'] = $id;
                $dados['title'] = 'Comentário de ' . $user->name . ' sobre o pedido ' . $req->key;
                $dados['recipient_id'] = $req->store_id;
                $dados['recipient_type'] = get_class($req->store);
            }
        }else{
            if($product = $this->product->find($id)){
                $dados['product_id'] = $id;
                $dados['title'] = 'Comentário de ' . $user->name . ' sobre o produto ' . $product->name;
                $dados['recipient_id'] = $product->store_id;
                $dados['recipient_type'] = get_class($product->store);
            }
        }
        if($message = $this->repo->store($dados)){
            $this->repo->update(['message_id'=>$message->id],$message->id);
            flash('Mensagem enviada com sucesso!', 'accept');
            return redirect()->back();
        }
        flash('Não foi possivel enviar a mensagem', 'error');
        return redirect()->back();
    }

    public function answer(Request $request, $id){
        $this->validate($request, [
            'message'=>'required|min:5:max:500'
        ]);


        if($model = $this->repo->get($id,$this->columns,$this->with)){
            if($model->message_id){
                $model = $this->repo->get($model->message_id,$this->columns,$this->with);
            }

            $cU = ($model->sender_type == 'App\Model\User');
            $cS = ($model->sender_type == 'App\Model\Store');


            $sender_id = ($cS ? Auth::user()->id : ($cU ? Auth::user()->salesman->store->id : Auth::user()->admin->id));
            $sender_type = ($cS ? get_class(Auth::user()) : ($cU ? get_class(Auth::user()->salesman->store) : get_class(Auth::user()->admin)));

            $recipient_id = $model->sender_id;
            $recipient_type = get_class($model->sender);


            if($model->sender_id == Auth::user()->id){
                $sender_id = Auth::user()->id;
                $sender_type = get_class(Auth::user());
                $recipient_id = $model->recipient_id;
                $recipient_type = $model->recipient_type;
            }
            $dados = [
                'sender_id' => $sender_id,
                'sender_type' => $sender_type,
                'recipient_id' => $recipient_id,
                'recipient_type' => $recipient_type,
                'message_type_id' => $model->message_type_id,
                'request_id' => $model->request_id,
                'product_id' => $model->product_id,
                'message_id' => $model->id,
                'title' => $model->title,
                'content' => $request->message
            ];

            $this->repo->filter_messages($request->message);
            if($message = $this->repo->store($dados)) {
                flash('Mensagem enviada com sucesso!', 'accept');
                return redirect()->back();
            }
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

    private function getAllMessages($data){
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $messages = $this->repo->getAllMessages($data,$this->columns, $this->with, ['id' => 'DESC'], 5, $page);
        $messages = ($messages->first() ? $messages : false);
        return $messages;
    }
}