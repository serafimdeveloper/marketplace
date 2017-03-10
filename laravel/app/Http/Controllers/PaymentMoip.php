<?php
namespace App\Http\Controllers;

use App\Package\Moip\lib\Moip;

class PaymentMoip extends Controller
{
    private $moip;

    function __construct()
    {
        $this->moip = new Moip;
        $this->moip->setEnvironment('test');
        $this->moip->setCredential([
            'key' => 'XYO36IZJGAC7SYZURZ8A4SAGMJ6TTKTU0FG4V5NN',
            'token' => 'DS60UI87KBYA9QW7HPLZLVNFSQ2KSDZA']);
        $this->moip->validate('Basic');
        $this->moip->setUniqueID('ABC1234')->setValue('100.00');
        $this->moip->setReason('Teste do Moip-PHP');
            $this->moip->setPayer(['name' => 'Nome Sobrenome', 'email' => 'contato@brunosite.com', 'payerId' => '2', 'billingAddress' => ['address' => 'Rua do Zézinho Coração', 'number' => '45', 'complement' => 'z', 'city' => 'São Paulo', 'neighborhood' => 'Palhaço Jão', 'state' => 'SP', 'country' => 'BRA', 'zipCode' => '01230-000', 'phone' => '(11)8888-8888']]);
            $this->moip->addPaymentWay('creditCard')->addPaymentWay('billet')->addPaymentWay('financing')->addPaymentWay('debit')->addPaymentWay('debitCard');
            $this->moip->setBilletConf("2011-04-06", false, ["Primeira linha", "Segunda linha", "Terceira linha"], "http://seusite.com.br/logo.gif");
            $this->moip->addMessage('Seu pedido contem os produtos X,Y e Z.');
            $this->moip->setReturnURL('http://popm.dev/accont/payment/callback');
            $this->moip->setNotificationURL('http://popm.dev/accont/order/notification');

        $this->moip->setReceiver('dev@asiw.com.br');
            $this->moip->addComission('Motivo da divisão', 'rendaok@live.com', '70.00', true);
//            ->addComission('Motivo da divisão', 'recebedor_secundario_2', '20.00', true)
            $this->moip->addParcel('1', '6', null, true);

        $send = $this->moip->send();
        dd($send);
    }

    public function show()
    {

    }
}
