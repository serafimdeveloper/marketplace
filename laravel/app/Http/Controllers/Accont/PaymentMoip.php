<?php
namespace App\Http\Controllers\Accont;

use App\Http\Controllers\AbstractController;
use App\Package\Moip\lib\Moip;

class PaymentMoip extends AbstractController
{
    private $moip;

    function __construct()
    {
        $this->moip = new Moip;
        $this->moip->setEnvironment('test');
        $this->moip->setCredential(['key' => 'XYO36IZJGAC7SYZURZ8A4SAGMJ6TTKTU0FG4V5NN', 'token' => 'DS60UI87KBYA9QW7HPLZLVNFSQ2KSDZA']);
        $this->moip->setUniqueID('sadfaew3wa')->setValue('100.00');
        $this->moip->setPayer(['name' => 'Contato Bruno Site', 'email' => 'contato@brunosite.com', 'payerId' => '2', 'billingAddress' => ['address' => 'Rua do Zézinho Coração', 'number' => '45', 'complement' => 'z', 'city' => 'São Paulo', 'neighborhood' => 'Palhaço Jão', 'state' => 'SP', 'country' => 'BRA', 'zipCode' => '01230-000', 'phone' => '(11)8888-8888']]);
        $this->moip->setReason('Teste do Moip-PHP');
        $this->moip->addPaymentWay('creditCard')->addPaymentWay('billet')->addPaymentWay('financing')->addPaymentWay('debit')->addPaymentWay('debitCard');
        $this->moip->setBilletConf("2011-04-06", false, ["Primeira linha", "Segunda linha", "Terceira linha"], "http://seusite.com.br/logo.gif");
        $this->moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
        $this->moip->setReturnURL('http://popm.dev/accont/payment/callback');
        $this->moip->setNotificationURL('http://popm.dev/accont/order/notification');
        $this->moip->addComission('Vendas da Loja 1', 'rendaok@live.com', '60.00', true, true);
        $this->moip->addComission('Vendas da Loja 2', 'comercial@asiw.com.br', '30.00', true, true);
        $this->moip->setReceiver('dev@asiw.com.br');
        $this->moip->addParcel('1', '6', null, true);
        $this->moip->validate('Identification');
    }

    public function repo(){

    }
    public function show(){
        $send = $this->moip->send();

        echo "<a style='background-color: #008973'>".$this->moip->getAnswer()->payment_url."</a>";
    }

    public function callback(){
        return view('accont.payment_callback');
    }

    public function notification(){
    }

    private function sadasd(){

    }
}
