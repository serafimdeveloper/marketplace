<?php
namespace App\Services;

use App\Model\address;
use App\Package\Moip\lib\Moip;
use Illuminate\Support\Facades\Auth;

class PaymentMoip
{
    private $moip;
    private $order;
    private $address;
    private $endpoint = null;

    function __construct($order){
        $this->order = $order;
        $this->address = $order->adress;
        $this->store = $order->store;
        $this->moip = new Moip;
        $this->moip->setEnvironment('test');
        $this->moip->setCredential(['key' => 'XYO36IZJGAC7SYZURZ8A4SAGMJ6TTKTU0FG4V5NN', 'token' => 'DS60UI87KBYA9QW7HPLZLVNFSQ2KSDZA']);

        $this->mount();
    }


    function mount(){
        $user = Auth::user();

        $this->moip->setUniqueID($this->order->key)->setValue($this->order->amount)->setAdds($this->order->freight_price);

        $this->moip->setPayer(['name' => $user->name . ' ' . $user->lastname, 'email' => $user->email, 'payerId' => $user->id, 'billingAddress' => ['address' => $this->address->public_place, 'number' => $this->address->number, 'complement' => $this->address->complements, 'city' => $this->address->city, 'neighborhood' => $this->address->neighborhood, 'state' => $this->address->state, 'country' => 'BR', 'zipCode' => (INT) $this->address->zip_code, 'phone' => $user->phone]]);
        $this->moip->setReason('Compra de produtos efetuada na plataforma Pop Martin');
        $this->moip->addPaymentWay('creditCard')->addPaymentWay('billet');
        $this->moip->setBilletConf(date('d/m/Y', strtotime("+3 days",strtotime(date('Y-m-d')))), false, ["Primeira linha", "Segunda linha", "Terceira linha"], url('imagem/pop/logo-popmartin.png'));
        $this->moip->addMessage('Produtos sendo comprados: ' . $this->getStringProducts());
        $this->moip->setReturnURL(url('accont/payment/callback'));
        $this->moip->setNotificationURL(url('accont/order/notification'));
        $this->moip->addComission('Comissão de venda Pop Matin', 'dev@asiw.com.br', ($this->store->comission ? $this->store->comission : 12), true, false);
        $this->moip->setReceiver($this->store->salesman->moip);
        $this->moip->addParcel('1', '6', null, true);
        $this->moip->validate('Identification');
    }

    public function send(){
        $this->moip->send();
        $this->endpoint = isset($this->moip->getAnswer()->payment_url) ? $this->moip->getAnswer()->payment_url : null;
    }

    public function getEndpoint(){
        return $this->endpoint;
    }

    public function getToken(){
        return $this->moip->getAnswer()->token ? $this->moip->getAnswer()->token : null;
    }

    private function getStringProducts(){
        $string = '';
        foreach($this->order->products as $product){
            $string .= '[' .  $product['name'] . "] | "
                . ' quantidade = ' . $product['qtd'] . " | "
                . ' Valor unitário = ' . real($product['price_unit']) . " | "
                . ' total = ' . real($product['subtotal']) . " | ------------";
        }
        return $string;
    }
}
