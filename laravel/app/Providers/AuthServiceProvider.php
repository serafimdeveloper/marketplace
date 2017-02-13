<?php

namespace App\Providers;

use App\Model\Admin;
use App\Model\Store;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Model\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
       #\App\Model\Message::class => \App\Policies\MessagePolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('vendedor', function (User $user){
            return !!$user->salesman;
        });

        Gate::define('admin', function (User $user){
           return  !!$user->admin;
        });

        Gate::define('store_access', function($user, $store){
            return $user->salesman->id === $store->salesman->id;
        });

        Gate::define('read_message', function ($user, $message){
            if($message->recipient_type === User::class){
                return $message->recipient_id === $user->id;
            }
            if($message->recipient_type === Admin::class){
                return $message->recipient_id === $user->admin->id;
            }
            if($message->recipient_type === Store::class){
                return $message->recipient_id === $user->salesman->store->id;
            }
            return false;
        });
    }
}
