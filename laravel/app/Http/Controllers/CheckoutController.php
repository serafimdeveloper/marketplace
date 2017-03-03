<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use Artesaos\Moip\facades\Moip;

class CheckoutController extends Controller{
    private $moip;

    function __construct(){
        $this->moip = Moip::start();
    }
    public function order(){
        try {
            $customer = $this->moip->customers()->setOwnId(uniqid())
                ->setFullname('Jose Silva')
                ->setEmail('sandbox_v2_1401147277@email.com')
                ->setBirthDate('1988-12-30')
                ->setTaxDocument('33333333333')
                ->setPhone(11, 66778899)
                ->addAddress('SHIPPING',
                    'Avenida Faria Lima', 2927,
                    'Itaim', 'Sao Paulo', 'SP',
                    '01234000', 8);

            $order1 = $this->moip->orders()->setOwnId(uniqid())
                ->addItem('Camisa Verde e Amarelo - Brasil', 1, 'Seleção Brasileira', 10000)
                ->setShippingAmount(100)
                ->setCustomer($customer)
                ->addReceiver('MPA-VB5OGTVPCI52');

            $order2 = $this->moip->orders()->setOwnId(uniqid())
                ->addItem('Camisa Preta - Alemanha', 1, 'Camisa da Copa 2014', 10000)
                ->setShippingAmount(100)
                ->setCustomer($customer)
                ->addReceiver('MPA-IFYRB1HBL73Z');

            $multiorder = $this->moip->multiorders()
                ->addOrder($order1)
                ->addOrder($order2)
                ->setOwnId(uniqid())
                ->create();

//            dd($multiorder);
//            $multipayments = $this->moip->multiorders()->get('MOR-8H8VSF36G5HT')->multipayments()->execute();

            $multpayment = $multiorder->multipayments();
            dd($multpayment);
        } catch (Exception $e) {
            dd($e->__toString());
        }

        return view('test.integrationmoip');
    }
}
