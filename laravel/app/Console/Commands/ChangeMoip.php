<?php

namespace App\Console\Commands;

use App\Services\MoipServices;
use Illuminate\Console\Command;

class ChangeMoip extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:moip';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar status de pedido';
    protected $moipService;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MoipServices $moipServices){
        parent::__construct();
        $this->moipService = $moipServices;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $this->moipService->checkStatusInstructions();
    }
}
