<?php

namespace App\Console\Commands;

use App\Model\Request;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Correios;

class CorreiosRequest extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request:correios';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Muda o status do pedido em relação ao correios';
    protected $request;

    /**
     * CorreiosRequest constructor.
     * @param Request $request
     */
    public function __construct(Request $request){
        parent::__construct();
        $this->request = $request;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $requests = $this->request->where('request_status_id', 4)->get();
        $requests->each(function($request){
            track_object($request->tracking_code, $request->id);
            sleep(5000);
        });
        \Log::info('Atualização de pedidos via Correios  em: ' . Carbon::now());
    }
}
