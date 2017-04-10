<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 24/01/2017
 * Time: 21:28
 */

namespace App\Repositories\Accont;

use App\Model\Admin;
use App\Model\User;
use App\Repositories\BaseRepository;
use App\Model\Message;
use GuzzleHttp\Psr7\ServerRequest;
use Illuminate\Support\Facades\Auth;

class MessagesRepository extends BaseRepository {
    public function model(){
        return Message::class;
    }

    public function getAllMessages(array $data, $columns = ['*'], array $with = [], $orders = [], $limit = 5, $page = 1){
        $messages = $this->model->with($with);
        $user = Auth::user();
        $store = [];
        if($salesman = $user->salesman){
            $store = isset($salesman->store) ? $salesman->store : '';
        }
        $admin = isset($user->admin) ? $user->admin : '';
        $class = ($data['type'] === 'user' ? $user : ($data['type'] === 'store' ? $store : $admin));
        $id = ($class == $user ? $user : ($class == $store ? $store : $admin));
        if($data['box'] === 'received'){
            $messages = $messages->where('recipient_id', $id->id)->where('recipient_type', get_class($class));
        }else{
            $messages = $messages->where('sender_id', $id->id)->where('sender_type', get_class($class));
        }
        $messages = $messages->where('desactive', 0);
        foreach($orders as $column => $order){
            $messages = $messages->orderBy($column, $order);
        }
        $messages = $messages->paginate($limit, $columns, 'page', $page);

        return $messages;
    }

    public function getMessages($message, array $with = [], $orders = [], $limit = 5, $page = 1){
        $messages = $this->model->with($with)->where(function($query) use ($message){
            $query->orwhere(function($or) use ($message){
                $or->where('recipient_id', $message->recipient_id)->where('recipient_type', get_class($message->recipient))->where('sender_id', $message->sender_id)->where('sender_type', get_class($message->sender));
            })->orwhere(function($or) use ($message){
                $or->where('recipient_id', $message->sender_id)->where('recipient_type', get_class($message->sender))->where('sender_id', $message->recipient_id)->where('sender_type', get_class($message->recipient));
            });
        });
        if(isset($message->request_id)){
            $messages = $messages->where('request_id', $message->request_id);
        }elseif(isset($message->product_id)){
            $messages = $messages->where('product_id', $message->product_id);
        }
        if(isset($message->message_id)){
            $messages = $messages->where('message_id', $message->message_id);
        }
        foreach($orders as $column => $order){
            $messages = $messages->orderBy($column, $order);
        }
//       $messages = $messages->paginate($limit,['*'], 'page', $page);
        $messages = $messages->get();

        return $messages;

    }

    public function filter_messages($content, $message = null){
        $rules['phone'] = "/([(]?[0-9]{2}[)]?[\s]*?)?([0-9]{4,5}[\s-._]*?[0-9]{4})/";
        $rules['email'] = "/[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)/";
        $rules['url'] = "/((http|https|ftp|ftps)?:\/\/)?([a-z0-9\-]+\.)?[a-z0-9\-]+\.[a-z0-9]{2,4}(\.[a-z0-9]{2,4})?(\/.*)?/";
        $msg_notify = array();
        $i = 0;
        foreach($rules as $key => $value){
            $i ++;
            if(preg_match($value, $content, $matches, PREG_OFFSET_CAPTURE)){
                $host = ServerRequest::fromGlobals()->getUri()->getHost();
                $msg_notify[$i] = mb_strtoupper($key) . ': ' . $matches[0][0];
                if($key == 'url' && preg_match("/" . $host . "/", $content)){
                    unset($msg_notify[$i]);
                    $i--;
                }
            }
        }
        if($msg_notify){
            $reason = '';
            foreach($msg_notify as $key => $value){
                $reason .= $value . ' | ';
            }
            $message->notify()->create([
                'reason' => $reason
            ]);
        }
    }
}