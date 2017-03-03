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
                ->setFullname('Fulano de Tal')
                ->setEmail('rendaok@live.com')
                ->setBirthDate('1988-12-30')
                ->setTaxDocument('22222222222')
                ->setPhone(11, 66778899)
                ->addAddress('BILLING',
                    'Rua de teste', 123,
                    'Bairro', 'Sao Paulo', 'SP',
                    '01234567', 8)
                ->addAddress('SHIPPING',
                    'Rua de teste do SHIPPING', 123,
                    'Bairro do SHIPPING', 'Sao Paulo', 'SP',
                    '01234567', 8);

            $order = $this->moip->orders()->setOwnId(uniqid())
                ->addItem('Bicicleta Specialized Tarmac 26 Shimano Alivio', 1, 'uma linda bicicleta', 10000)
                ->setCustomer($customer)
                ->create();

            dd($order);
        } catch (Exception $e) {
            dd($e->__toString());
        }

        return view('test.integrationmoip');
    }
}
