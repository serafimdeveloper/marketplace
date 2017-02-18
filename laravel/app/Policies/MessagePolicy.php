<?php

namespace App\Policies;

use App\Model\Admin;
use App\Model\Message;
use App\Model\Store;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function read_message(User $user, Message $message, $box = 'received'){
        $colum['type'] = ($box === 'received' ? 'recipient_type' : 'sender_type');
        $colum['id'] = ($box === 'received' ? 'recipient_id' : 'sender_id');

        $recipient = app($message->{$colum['type']});

        if($recipient instanceof User){
            return $message->{$colum['id']} === $user->id;
        }
        if($recipient instanceof Admin){
            return $message->{$colum['id']} === $user->admin->id;
        }
        if($recipient instanceof Store){
            return $message->{$colum['id']} === $user->salemsn->store->id;
        }
        return false;
    }
}
