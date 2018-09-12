<?php

namespace App\Policies;

use App\Model\User;
use App\Model\Request;
use App\Model\Store;
use Illuminate\Auth\Access\HandlesAuthorization;

class SellerPolicy
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

    public function store_access(User $user, Store $store){
        dd($user);
       return $user->seller->id === $store->seller->id;

    }

    public function request_access(User $user, Store $store, Request $request){
        if($this->store_access($user,$store)){
            return $request->store_id === $store->id;
        }
        return false;
    }

}
