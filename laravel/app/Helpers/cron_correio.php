<?php

use App\Model\Request;
use Correios;

$requests = Request::where('request_status_id',4)->get();
\Illuminate\Contracts\Logging\Log::info("teste");
$requests->each(function($request){
    $status_freigth = Correios::rastrear($request->zip_code);
    if($status_freigth[0]['status'] === 'Entrega Efetuada'){
        $request->fill(['request_status_id' => 5])->save();
    }

    sleep(5000);
});