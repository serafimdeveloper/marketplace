<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 12/04/2017
 * Time: 20:40
 */

namespace App\Http\Controllers\Account\Admin;


use App\Model\User;
use App\Repositories\Account\MessagesRepository;
use App\Repositories\Account\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifyController extends AbstractAdminController
{
    public function __construct(NotificationRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(){
        if($admin = Auth::user()->admin){
            $ntfs = $this->repo->all(['*'],[], [], ['id' => 'DESC'], 20);
            return view('account.report.notifications', compact('ntfs'));
        }else{
            return redirect()->route('account.home');
        }

    }

    public function show($id){
        if($admin = Auth::user()->admin){
            if($ntf = $this->repo->get($id)){
                $sender = null; $recipient = null;
                if(app($ntf->message->sender_type) instanceof User){
                    $sender = [
                        'id' => $ntf->message->sender->id,
                        'name' => $ntf->message->sender->name .' '. $ntf->message->sender->last_name,
                        'email' => $ntf->message->sender->email
                    ];
                }else{
                    $sender = [
                        'id' => $ntf->message->sender->seller->user->id,
                        'name' => $ntf->message->sender->seller->user->name .' '. $ntf->message->sender->seller->user->lastname,
                        'email' => $ntf->message->sender->seller->user->email,
                        'store' => $ntf->message->sender
                    ];
                }

                if(app($ntf->message->recipient_type) instanceof User){
                    $recipient = [
                        'id' => $ntf->message->recipient->id,
                        'name' => $ntf->message->recipient->name . ' ' . $ntf->message->recipient->last_name,
                        'email' => $ntf->message->recipient->email
                    ];
                }else{
                    $recipient = [
                        'id' => $ntf->message->recipient->seller->user->id,
                        'name' => $ntf->message->recipient->seller->user->name . ' ' . $ntf->message->recipient->seller->user->last_name,
                        'email' => $ntf->message->recipient->seller->user->email,
                        'store' => $ntf->message->recipient
                    ];
                }
            };
            $this->repo->update(['read' => 1], $id);
            return view('layouts.parties.alert_notification', compact('ntf', 'sender', 'recipient'));
        }
    }

    public function update(Request $request, MessagesRepository $messagesRepository){
        if($admin = Auth::user()->admin){
            if($result = $messagesRepository->update(['content' => $request->input('content')], $request->input('message_id'))){
                return response()->json(['msg' => 'Mensagem editada com sucesso!']);
            }
        }
        return response()->json(['msg' => 'Erro ao encontrar o vendedor'],404);
    }

    public function destroy(Request $request, MessagesRepository $messagesRepository){
        if($admin = Auth::user()->admin){
            if($result = $messagesRepository->delete($request->input('id'))){
                return response()->json(['msg' => 'Mensagem removida com sucesso!']);
            }
        }
        return response()->json(['msg' => 'Erro ao encontrar o vendedor'],404);
    }

}