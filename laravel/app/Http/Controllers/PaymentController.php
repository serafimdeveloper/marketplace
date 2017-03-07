<?php

namespace App\Http\Controllers;

use Artesaos\Moip\facades\Moip;
use Illuminate\Http\Request;

class PaymentController extends Controller{
    private $moip, $order = null, $type = 'setMultPayments';

    function __construct(){
        $this->moip = Moip::start();
        $this->constructOrder();
    }

    public function order(Request $request){
        $this->type = ($request->set_type ? $request->set_type : $this->type);
        if($request->set_method == 'cardcred'){
            $this->setCreditCard();
        }elseif($request->set_method == 'boleto'){
            $this->setBoleto();
        }elseif($request->set_method == 'bank'){
            $this->setOnlineBankDebit();
        }elseif($request->set_method == 'wallet'){
            $this->setWallet();
        }
    }

    private function constructOrder(){
        $customer = $this->moip->customers()->setOwnId('sandbox_v2_1401147277')
            ->setFullname('Jose Silva')
            ->setEmail('sandbox_v2_1401147277@email.com')
            ->setBirthDate('1988-12-30')
            ->setTaxDocument('33333333333')
            ->setPhone(11, 66778899)
            ->addAddress('SHIPPING',
                'Avenida Faria Lima', 2927,
                'Itaim', 'Sao Paulo', 'SP',
                '01234000', 8);

        $order1 = $this->moip->orders()->setOwnId('multi-pedido-1')
            ->addItem('Camisa Verde e Amarelo - Brasil', 1, 'Seleção Brasileira', 10000)
            ->setShippingAmount(100)
            ->setCustomer($customer)
            ->addReceiver('MPA-VB5OGTVPCI52');

        $order2 = $this->moip->orders()->setOwnId('multi-pedido-2')
            ->addItem('Camisa Preta - Alemanha', 1, 'Camisa da Copa 2014', 10000)
            ->setShippingAmount(100)
            ->setCustomer($customer)
            ->addReceiver('MPA-IFYRB1HBL73Z');

        $this->order = $this->moip->multiorders()->addOrder($order1)
            ->addOrder($order2)
            ->setOwnId('multi-pedido')
            ->create();
    }


    private function setMultPayments(){
        return $this->moip->multiorders()->get($this->order->getId())->multipayments();
    }

    public function setCreditCard(){
        //Dados de exemplo
        $ccNumber = '5555666677778884';
        $cvcNumber = '123';

        $this->{$this->type}()->setCreditCard('05','18', $ccNumber, $cvcNumber, $this->order)->execute();
        dd($this->{$this->type}());
    }

    public function setBoleto(){
        $this->{$this->type}()->setBoleto(
            '2016-09-30',
            'https://image.freepik.com/free-icon/apple-logo_318-40184.jpg',
//            'http://popmartin.dev/imagem/pop/logo-popmartin.png',
            array(
                'Primeira linha se instrução',
                'Segunda linha se instrução',
                'Terceira linha se instrução'
            )
        )->execute();

        dd($this->order, 'setBoleto');
    }

    public function setOnlineBankDebit(){
//        $multipayments->setOnlineBankDebit('001', '2016-12-30', 'https://return-uri.com')->execute();
        dd('setOnlineBankDebit');
    }

    public function setWallet(){
        dd('setWallet');
    }
}
