<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Faker\Generator as FakerGenerator;
use Faker\Factory as FakerFactory;
use App;
use URL;

class AppServiceProvider extends ServiceProvider

{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Carbon\Carbon::setLocale($this->app->getLocale());

        if (!\App::environment('local')) {
            \URL::forceSchema('https');
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FakerGenerator::class, function () {
            return FakerFactory::create('pt_BR');
        });

        $this->app->singleton('League\Glide\Server', function($app){

            $filesystem = $app->make('Illuminate\Contracts\Filesystem\Filesystem');
            $factory = $app->make('League\Glide\Responses\LaravelResponseFactory');

            return \League\Glide\ServerFactory::create([
                'response' => $factory,
                'source' => $filesystem->getDriver(),
                'cache' => $filesystem->getDriver(),
                'watermarks' => $filesystem->getDriver(),
                'source_path_prefix' => 'img',
                //'cache_path_prefix' => 'img/.cache',
                'watermarks_path_prefix' => 'img/watermarks',
                // 'base_url' => 'photos',
            ]);
        });
    }
}
