<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\AbstractController;
use Illuminate\Http\Request;

class CreditCardController extends AbstractController {
    private $payment;
    public function repo(){
    }


    function __construct(){
       $this->payment = new PaymentController;
    }

    public function show(){
        $this->toPay();
    }

    private function toPay(){

        //Dados de exemplo
        $ccNumber = '5555666677778884';
        $cvcNumber = '123';

        $pay = $this->payment->setMultPayments()->setCreditCard('05','18', $ccNumber, $cvcNumber, $this->payment->getCustomer())->execute();

        dd($pay);
    }
}
