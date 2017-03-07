<?php

namespace App\Http\Controllers;

use App\Http\Requests\Accont\AdressesStoreRequest;
use App\Repositories\Accont\RequestsRepository;
use Artesaos\Moip\facades\Moip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Correios;
use App\Repositories\Accont\AdressesRepository;

class PaymentController extends Controller{
    private $moip;

    function __construct(){
        $this->moip = Moip::start();
    }

    public function order(Request $request){
        //        https://sandbox.moip.com.br/v2/multiorders/{multiorder_id}/multipayments

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

        $multiorder = $this->moip->multiorders()->addOrder($order1)
            ->addOrder($order2)
            ->setOwnId('multi-pedido')
            ->create();

        dd($multiorder);
        return view('test.integrationmoip');
    }

    public function setMultPayments(){
//        https://sandbox.moip.com.br/v2/multiorders/MOR-8H8VSF36G5HT/multipayments

//        $multipayments = $moip->multiorders()->get('MOR-8H8VSF36G5HT')->multipayments();

    }

    public function setCreditCard(){
//        https://sandbox.moip.com.br/v2/multiorders/MOR-8H8VSF36G5HT/multipayments

//        $multipayments->setCreditCard('05','18', $ccNumber, $cvcNumver, $customer)->execute();
    }

    public function setBoleto(){
//        https://sandbox.moip.com.br/v2/multiorders/MOR-QXZKIF6GPN5V/multipayments

//        $multipayments->setBoleto('2016-09-30', 'https://logo-uri.com', array('Primeira linha se instrução',
//            'Segunda linha se instrução',
//            'Terceira linha se instrução'))
//            ->execute();
    }

    public function setOnlineBankDebit(){
//        https://sandbox.moip.com.br/v2/multiorders/MOR-BZ1UC1FEZUWG/multipayments

//        $multipayments->setOnlineBankDebit('001', '2016-12-30', 'https://return-uri.com')->execute();
    }

    public function setWallet(){

    }
}
