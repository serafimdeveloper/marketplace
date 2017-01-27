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
        \App\Model\Sallesman::class => \App\Policies\VendedorPolicy::class,
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
            return $user->profile_access === 'salesman';
        });

        Gate::define('admin', function (User $user){
           return  $user->profile_access === 'admin';
        });
        //
    }
}
