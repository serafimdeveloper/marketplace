<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 22/03/2017
 * Time: 14:35
 */

namespace App\Http\Controllers\Accont\Admin;


use App\Http\Controllers\Controller;
use App\Model\User;
use App\Repositories\Accont\MessagesRepository;
use App\Repositories\Accont\NotificationRepository;
use App\Repositories\Accont\ProductsRepository;
use App\Repositories\Accont\RequestsRepository;
use App\Repositories\Accont\SalesmanRepository;
use App\Repositories\Accont\UserRepository;
use App\Repositories\AdRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    protected $with = [];
    protected $columns = ['*'];
    protected $ordy = [];
    protected $title = '';
    protected $placeholder = '';
    protected $limit = 15;

    public function __construct()
    {
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_accont');
        }
        dd('teste');
    }

    public function list_users(Request $request, UserRepository $repo){
        $this->with  = ['addresses','requests'];
        $this->ordy  = ['name'=>'ASC'];
        $this->title = 'Listas de Usuários';
        $this->placeholder = 'Pesquisar por nome ou email';
        $data = $this->search($request, 'users', $repo);
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }

    public function get_user_id(UserRepository $repo, $id){
        $this->with  = ['addresses','requests'];
        $type = 'usuario';
        if($result = $this->getByRepoId($repo, $id)){
            return view('layouts.parties.alert_user_info', compact('result','type'));
        }
        return response()->json(['msg' => 'Erro ao encontrar o usuário'],404);
    }

    public function list_sallesmans(Request $request, SalesmanRepository $repo){
        $this->ordy = ['name' => 'ASC'];
        $this->title = 'Vendedores Cadastrado no Sistema';
        $this->placeholder = 'Pesquisar por nome ou email';
        $data = $this->search($request, 'sallesmans', $repo);
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }

    public function get_sallesman_id(SalesmanRepository $repo, $id){
        $this->with = ['user','store'];
        if($result = $this->getByRepoId($repo, $id)){
            $type = 'vendedor';
            return view('layouts.parties.alert_salesman_info', compact('result','type'));
        }
        return response()->json(['msg' => 'Erro ao encontrar o vendedor'],404);
    }

    public function list_products(Request $request, ProductsRepository $repo){
        $this->ordy = ['name' => 'ASC'];
        $this->with = ['store','galeries'];
        $this->title = 'Lista de Todos os Produtos';
        $this->placeholder = 'Pesquisar pelo nome do produto';
        $data = $this->search($request, 'products', $repo);
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }

    public function get_product_id(ProductsRepository $repo, $id){
        if($result = $this->getByRepoId($repo, $id)){
            return view('layouts.parties.alert_product_info', compact('result'));
        }
        return response()->json(['msg' => 'Erro ao encontrar o produto'],404);
    }

    public function list_sales(Request $request, RequestsRepository $repo){
        $this->ordy = ['created_at' => 'DES'];
        $this->title = 'Vendas / Comissões';
        $this->with = ['store','user','adress','freight','products','requeststatus'];
        $this->placeholder = 'Pesquisar pelo nome do cliente ou código do pedido';
        $data = $this->search($request, 'sales', $repo);
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }

    public function get_sale_id(RequestsRepository $repo, $id){
        $this->with = ['user','store','adress','products','payment','requeststatus','freight'];
        if($result = $this->getByRepoId($repo, $id)){
            return view('layouts.parties.alert_sales_info', compact('result'));
        }
        return response()->json(['msg' => 'Erro ao encontrar a venda'],404);
    }

    public function list_banners(Request $request, AdRepository $repo){
        $this->ordy = ['name' => 'ASC'];
        $this->with = ['store'];
        $this->title = 'Banners';
        $data = $this->search($request, 'banners', $repo);
        if($request->ajax()){
            return view('accont.report.presearch', $data);
        }
        return view('accont.report.search', $data);
    }

    public function list_notify(NotificationRepository $notification){
        if($admin = Auth::user()->admin){
            $ntfs = $notification->all(['*'],[], [], ['id' => 'DESC'], 20);
            return view('accont.report.notifications', compact('ntfs'));
        }else{
            return redirect()->route('accont.home');
        }

    }


    public function list_notify_id(NotificationRepository $notification, $id){
        if($admin = Auth::user()->admin){
            if($ntf = $notification->get($id)){
                $sender = null; $recipient = null;
                if(app($ntf->message->sender_type) instanceof User){
                    $sender = [
                        'id' => $ntf->message->sender->id,
                        'name' => $ntf->message->sender->name .' '. $ntf->message->sender->last_name,
                        'email' => $ntf->message->sender->email
                    ];
                }else{
                    $sender = [
                        'id' => $ntf->message->sender->salesman->user->id,
                        'name' => $ntf->message->sender->salesman->user->name .' '. $ntf->message->sender->salesman->user->lastname,
                        'email' => $ntf->message->sender->salesman->email,
                        'store' => $ntf->message->sender
                    ];
                }

                if($ntf->message->recipient_type instanceof User){
                    $recipient = [
                        'id' => $ntf->message->recipient->id,
                        'name' => $ntf->message->recipient->name . ' ' . $ntf->message->recipient->last_name,
                        'email' => $ntf->message->recipient->email
                    ];
                }else{
                    $recipient = [
                        'id' => $ntf->message->recipient->salesman->user->id,
                        'name' => $ntf->message->recipient->salesman->user->name . ' ' . $ntf->message->recipient->salesman->user->last_name,
                        'email' => $ntf->message->recipient->salesman->user->email,
                        'store' => $ntf->message->recipient
                    ];
                }
            };
            $notification->update(['read' => 1], $id);
            return view('layouts.parties.alert_notification', compact('ntf', 'sender', 'recipient'));
        }
    }

    public function list_notify_edit(Request $request, MessagesRepository $messagesRepository){
        if($admin = Auth::user()->admin){
            if($result = $messagesRepository->update(['content' => $request->input('content')], $request->input('message_id'))){
                return response()->json(['msg' => 'Mensagem editada com sucesso!']);
            }
        }
        return response()->json(['msg' => 'Erro ao encontrar o vendedor'],404);
    }

    public function list_notify_removemsg(Request $request, MessagesRepository $messagesRepository){
        if($admin = Auth::user()->admin){
            if($result = $messagesRepository->delete($request->input('id'))){
                return response()->json(['msg' => 'Mensagem removida com sucesso!']);
            }
        }
        return response()->json(['msg' => 'Erro ao encontrar o vendedor'],404);
    }

    public function get_banner_id(AdRepository $repo, $id){
        if($result = $this->getByRepoId($repo, $id)){
            return response()->json(compact('result'));
        }
        return response()->json(['msg' => 'Erro ao encontrar o vendedor'],404);
    }

    private function search($request, $type, $repo){
        $page = Input::get('page') ? Input::get('page') : 1 ;
        $result = $repo->search($request->name, $this->columns, $this->with, $this->ordy, $this->limit, $page);
        return ['type' => $type, 'result' => $result, 'title' => $this->title, 'placeholder' => $this->placeholder];

    }

    private function getByRepoId($repo, $id){
        if($result = $repo->get($id,$this->columns,$this->with)){
            return $result;
        }
        return false;
    }


}