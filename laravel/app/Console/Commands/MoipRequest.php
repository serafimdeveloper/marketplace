<?php

namespace App\Console\Commands;

use App\Services\MoipServices;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MoipRequest extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request:moip';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar status de pedido em relação ao Moip';
    protected $moipService;

    /**
     * MoipRequest constructor.
     * @param MoipServices $moipServices
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
        Log::info('Atualização do MOIP  em: '. Carbon::now());
    }
}
