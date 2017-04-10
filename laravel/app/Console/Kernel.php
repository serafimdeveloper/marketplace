<?php

namespace App\Console;

use App\Console\Commands\MoipRequest;
use App\Console\Commands\CorreiosRequest;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [CorreiosRequest::class, MoipRequest::class];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule){
        $schedule->command('request:correios')->everyMinute();
        $schedule->command('request:moip')->everyMinute();

    }

    /**
     * Register the Closure based commands for the application.
     * @return void
     */
    protected function commands(){
        require base_path('routes/console.php');
    }
}
