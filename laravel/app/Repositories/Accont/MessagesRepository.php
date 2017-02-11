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

class MessagesRepository extends BaseRepository
{

    public function model()
    {
        return Message::class;
    }

    public function getMessages($id, array $with = [],$orders = [], $limit=5, $page = 1){
       $message = $this->get($id);
       $messages = $this->model->with($with)
       ->where(function($query) use($message){
           $query->orwhere(function($or) use($message){
               $or->where('recipient_id', $message->recipient_id)
                  ->where('sender_id', $message->sender_id);
           })->orwhere(function($or) use($message){
               $or->where('recipient_id', $message->sender_id)
                  ->where('sender_id', $message->recipient_id);
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