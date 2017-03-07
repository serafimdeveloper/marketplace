<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;

class BoletoController extends Controller{
    private $payment;

    function __construct(){
       $this->payment = new PaymentController;
    }

    private function updateOrder(){

    }

    private function toPay(){
        //Dados de exemplo
        $ccNumber = '5555666677778884';
        $cvcNumber = '123';

        $this->payment->setMultPayments()->setCreditCard('05','18', $ccNumber, $cvcNumber, $this->order)->execute();
        dd($this->{$this->type}());
    }
}
