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

    public function index(){
        $this->toPay();
    }

    private function toPay(){

//        dd($this->payment->multorder);

        //Dados de exemplo
        $ccNumber = '5555666677778884';
        $cvcNumber = '123';

        $this->payment->setMultPayments()->setCreditCard('05','18', $ccNumber, $cvcNumber, $this->order)->execute();
    }
}
