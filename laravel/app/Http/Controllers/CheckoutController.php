<?php

namespace App\Http\Controllers;

use Artesaos\Moip\facades\Moip;
use Illuminate\Http\Request;

class CheckoutController extends Controller{
    private $moip;

    function __construct(){
        $this->moip = Moip::start();
    }
    public function order(Request $request){
        $order = $this->moip->orders()->setOwnId('seu_identificador_proprio')
            ->addItem('Descrição do pedido', 1, 'Mais info...', 10000)
            ->setShippingAmount(100)
            ->setCustomer($this->moip->customers()->setOwnId('seu_identificador_proprio_de_cliente')
                ->setFullname('Jose Silva')
                ->setEmail('nome@email.com')
                ->setBirthDate('1988-12-30')
                ->setTaxDocument('33333333333')
                ->setPhone(11, 66778899)
                ->addAddress('BILLING',
                    'Avenida Faria Lima', 2927,
                    'Itaim', 'Sao Paulo', 'SP',
                    '01234000', 8))
//            ->setCheckout()
            ->create();

        $ccNumber = '5555666677778884';
        $cvcNumber = '123';


        $payment = $order->payments()
            ->setCreditCard('05', '18', $ccNumber, $cvcNumber,
                $this->moip->customers()->setOwnId('sandbox_v2_1401147277')
                    ->setFullname('Jose Portador da Silva')
                    ->setEmail('fulano@email.com')
                    ->setBirthDate('1988-12-30')
                    ->setTaxDocument('33333333333')
                    ->setPhone(11, 66778899))
            ->execute();

        dd($payment->get('seu_identificador_proprio'));
        return view('test.integrationmoip');
    }
}
