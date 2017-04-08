<?php

namespace App\Console\Commands;

use App\Model\Request;
use Illuminate\Console\Command;
use Correios;

class ChangeRequest extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request:change';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Muda o status do pedido';
    protected $request;

    /**
     * Create a new command instance.
     *
     * @return void
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
            $status_freigth = Correios::rastrear($request->zip_code);
            if($status_freigth[0]['status'] === 'Entrega Efetuada'){
                $request->fill(['request_status_id' => 5])->save();
            }
            sleep(5000);
        });
    }
}
