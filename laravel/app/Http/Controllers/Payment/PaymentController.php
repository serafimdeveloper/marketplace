<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\AbstractController;

class PaymentController extends AbstractController {
    private $moip, $customer;
    public $order = array(), $multorder;


    function __construct(){
        $this->moip = Moip::start();
        $this->setCustomer();
        $this->setOrder();
        $this->setMultOrders();
    }

    public function repo(){
    }

    public function getCustomer(){
        return $this->customer;
    }

    public function getMoip(){
        return $this->moip;
    }

    public function setCustomer(){
        $this->customer = $this->moip->customers()->setOwnId('sandbox_v2_1401147277')
            ->setFullname('Jose Silva')
            ->setEmail('sandbox_v2_1401147277@email.com')
            ->setBirthDate('1988-12-30')
            ->setTaxDocument('16223006888')
            ->setPhone(11, 66778899)
            ->addAddress('SHIPPING',
                'Avenida Faria Lima', 2927,
                'Itaim', 'Sao Paulo', 'SP',
                '01234000', 8);
    }

    public function setOrder($order = null){
        $this->order[] = $this->moip->orders()->setOwnId('multi-pedido-1')
            ->addItem('Camisa Verde e Amarelo - Brasil', 1, 'Seleção Brasileira', 10000)
            ->setShippingAmount(100)
            ->setCustomer($this->customer)
            ->addReceiver('MPA-E1DB1C93CD3B', 'PRIMARY');

        $this->order[] = $this->moip->orders()->setOwnId('multi-pedido-2')
            ->addItem('Camisa de Gola - Brasil', 1, 'Minotauro', 8800)
            ->setShippingAmount(100)
            ->setCustomer($this->customer)
            ->addReceiver('MPA-0894C989C657', 'PRIMARY');
    }

    public function setMultOrders(){
        if($this->order){
            $this->multorder = $this->moip->multiorders();
            for($i = 0; $i < count($this->order); $i++){
                $this->multorder->addOrder($this->order[$i]);
            }
            $this->multorder->setOwnId('multi-pedido')->create();
        }
    }

    public function setMultPayments(){
        return $this->multorder->multipayments();
    }

}
