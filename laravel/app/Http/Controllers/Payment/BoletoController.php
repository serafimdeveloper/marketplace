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
        $payment = $this->payment->setMultPayments()->setBoleto(
            '2016-09-30',
            'https://image.freepik.com/free-icon/apple-logo_318-40184.jpg',
//            'http://popmartin.dev/imagem/pop/logo-popmartin.png',
            array(
                'Primeira linha se instrução',
                'Segunda linha se instrução',
                'Terceira linha se instrução'
            )
        )->execute();

        dd($payment);
    }
}
