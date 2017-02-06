<?php

namespace App\Providers;

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
       # \App\Model\Salesman::class => \App\Policies\SalesmanPolicy::class,
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
    }
}
