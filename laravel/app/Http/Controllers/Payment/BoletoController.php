<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BoletoController extends Controller {
    private $payment;

    function __construct(){
       $this->payment = new PaymentController;

    }

    public function repo(){

    }

    public function show(){
        $this->toPay();
    }

    private function updateOrder(){

    }

    private function toPay(){
        $pay = $this->payment->setMultPayments()->setBoleto(
            date("Y-m-d"),
            null,
//            'http://popmartin.dev/imagem/pop/logo-popmartin.png',
            array(
                'Primeira linha se instrução',
                'Segunda linha se instrução',
                'Terceira linha se instrução'
            )
        )->execute();

        dd($pay);
    }
}
