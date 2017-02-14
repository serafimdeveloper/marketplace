<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 24/01/2017
 * Time: 21:28
 */

namespace App\Repositories\Accont;


use App\Repositories\BaseRepository;
use App\Model\Message;
use Illuminate\Support\Facades\Auth;

class MessagesRepository extends BaseRepository
{

    public function model()
    {
        return Message::class;
    }

    public function getAllMessages($type,$columns = ['*'], array $with = [], $orders = [], $limit = 5, $page = 1 ){
        $user = Auth::user();
        $messages = $this->model->with($with);
        if($type === 'user'){
            $messages = $messages->where('recipient_id', $user->id)
                ->where('recipient_type', get_class($user));
        }else if($type === 'store'){
            $store = $user->salesman->store;
            $messages = $messages->where('recipient_id', $store->id)
                ->where('recipient_type', get_class($store));
        }else{
            $admin = $user->admin;
            $messages = $messages->where('recipient_id', $admin->id)
                ->where('recipient_type', get_class($admin));
        }
        $messages = $messages->where('desactive',0);
        foreach ($orders as $column => $order) {
            $messages = $messages->orderBy($column, $order);
        }

        $messages = $messages->paginate($limit,$columns, 'page', $page);
        return $messages;
    }

    public function getMessages($message, array $with = [],$orders = [], $limit=5, $page = 1){
       $messages = $this->model->with($with)
       ->where(function($query) use($message){
           $query->orwhere(function($or) use($message){
               $or->where('recipient_id', $message->recipient_id)->where('recipient_type', get_class($message->recipient))
                  ->where('sender_id', $message->sender_id)->where('sender_type', get_class($message->sender));
           })->orwhere(function($or) use($message){
               $or->where('recipient_id', $message->sender_id)->where('recipient_type', get_class($message->sender))
                  ->where('sender_id', $message->recipient_id)->where('sender_type', get_class($message->recipient));
           });
       });
       if(isset($message->request_id)){
           $messages = $messages->where('request_id',$message->request_id);
       }
       else if(isset($message->product_id)){
            $messages = $messages->where('product_id',$message->product_id);
       }
       if(isset($message->message_id)){
            $messages = $messages->where('message_id',$message->message_id);
       }
       foreach ($orders as $column => $order) {
           $messages = $messages->orderBy($column, $order);
       }

       $messages = $messages->paginate($limit,['*'], 'page', $page);
       return $messages;

    }
}