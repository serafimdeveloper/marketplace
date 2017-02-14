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

    public function read_message(User $user, Message $message){
        $recipient = app($message->recipient_type);
        if($recipient instanceof User){
            return $message->recipient_id === $user->id;
        }
        if($recipient instanceof Admin){
            return $message->recipient_id === $user->admin->id;
        }
        if($recipient instanceof Store){
            return $message->recipient_id === $user->salemsn->store->id;
        }
        return false;
    }
}
