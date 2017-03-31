<?php
namespace App\Providers;

use App\Model\Admin;
use App\Model\Request;
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
    protected $policies = [#\App\Model\Message::class => \App\Policies\MessagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('vendedor', function(User $user){
            return !!$user->salesman;
        });
        Gate::define('admin', function(User $user){
            return !!$user->admin;
        });
        Gate::define('store_access', function($user, $store){
            if(Gate::allows('vendedor')){
                return $user->salesman->id === $store->salesman->id;
            }
        });

        Gate::define('is_active', function($user){
            return !!$user->active;
        });


        Gate::define('orders', function(User $user, Request $order){
            if($user->salesman->store->id === $order->store->id){
                return true;
            }elseif($user->id === $order->user->id){
                return true;
            }
            return false;
        });

        Gate::define('read_message', function($user, $message){
            $recipient = app($message->recipient_type);
            if($recipient instanceof User){
                if($message->recipient_id === $user->id){
                    return true;
                }
            }
            if($recipient instanceof Admin){
                if($user->admin->id){
                    return true;
                }
            }
            if($recipient instanceof Store){
                if($message->recipient_id === $user->salesman->store->id){
                    return true;
                }
            }
            return false;
        });


//        Gate::define('read_message', function($user, $message, $box = 'received'){
//            $colum['type'] = ($box === 'received' ? 'recipient_type' : 'sender_type');
//            $colum['id'] = ($box === 'received' ? 'recipient_id' : 'sender_id');
//            $recipient = app($message->{$colum['type']});
//
//            if($recipient instanceof User){
//                return $message->{$colum['id']} === $user->id;
//            }
//            if($recipient instanceof Admin){
//                return $message->{$colum['id']} === $user->admin->id;
//            }
//            if($recipient instanceof Store){
////                dd($message->{$colum['id']} === $user->salesman->store->id);
//                return $message->{$colum['id']} === $user->salesman->store->id;
//            }
//            return false;
//        });
    }
}
