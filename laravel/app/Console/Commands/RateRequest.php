<?php

namespace App\Console\Commands;

use App\Model\Request;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RateRequest extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request:rate';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica o prazo limite de avaliação para cada pedido';
    protected $rateRequest;

    /**
     * Create a new command instance.
     * RateRequest constructor.
     * @param Request $request
     */
    public function __construct(Request $request){
        parent::__construct();
        $this->rateRequest = $request;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        $now = Carbon::now();
        $limit = $now->subDays(5);
        $orders = $this->rateRequest
            ->where('request_status_id', '=', 5)
            ->where('updated_at', '<', $limit)->get();
        if(count($orders)){
            $orders->each(function($order){
                if(!$order->shopvaluation){
                    $order->shopvaluation()->fill([
                       'user_id' => $order->user_id,
                       'store_id' => $order->store_id,
                       'note_product' => 5,
                       'note_attendance' => 5,
                       'comment' => 'Vendedor rápido e atencioso. Recomendo!',
                       'active' => 1
                    ]);
                }
                Log::info('Avaliação do pedido: ' . $order->key . ' | hora:'. Carbon::now());
            });
            Log::info('Avaliação do pedido:  | hora:'. Carbon::now());
        }
    }
}
