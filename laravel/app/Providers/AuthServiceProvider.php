<?php

namespace App\Providers;

use App\Model\Admin;
use App\Model\Request;
use App\Model\Store;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Model\User;

class AuthServiceProvider extends ServiceProvider {
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [#\App\Model\Message::class => \App\Policies\MessagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(){
        $this->registerPolicies();

        Gate::define('vendedor', function(User $user){
           return $user->seller || $user->admin;
        });

        Gate::define('seller', function(User $user){
            return !!$user->seller;
        });

        Gate::define('admin', function(User $user){
            return !!$user->admin;
        });

        Gate::define('store_access', function($user, $store){
            if(Gate::allows('vendedor')){
                if($user->seller && $store->seller){
                    return $user->seller->id === $store->seller->id;
                }
            }
        });

        Gate::define('is_active', function($user){
            return !!$user->active;
        });

        Gate::define('produtc_access', function(User $user, $product){
            if($product){
                $store_id = (isset($user->seller->store) && $user->seller->store ? $user->seller->store->id : null);
                if($product->store->id == $store_id || $user->admin){
                    return true;
                }
            }

            return false;
        });

        Gate::define('orders', function(User $user, Request $order){
            if($user->seller->store->id === $order->store->id){
                return true;
            }elseif($user->id === $order->user->id){
                return true;
            }

            return false;
        });

        Gate::define('read_message', function($user, $message, $box){
            $reader = ($box === 'received') ? app($message->recipient_type) : app($message->sender_type);
            $reader_id = ($box === 'received') ? $message->recipient_id : $message->sender_id;
            if($reader instanceof User){
                if($reader_id === $user->id){
                    return true;
                }
            }elseif($reader instanceof Store){
                if(Gate::denies('vendedor', $user)){
                    return false;
                }elseif($reader_id === $user->seller->store->id){
                    return true;
                }
            }elseif($reader instanceof Admin){
                return true;
            }

            return false;
        });

    }
}
