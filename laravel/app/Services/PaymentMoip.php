<?php
namespace App\Services;

use App\Model\Adress;
use App\Model\Store;
use App\Package\Moip\lib\Moip;
use Illuminate\Support\Facades\Auth;

class PaymentMoip
{
    private $moip;
    private $cart;
    private $address;
    private $endpoint = null;

    function __construct($cart, $address){
        $this->cart = $cart;
        $this->address = $address;
        $this->moip = new Moip;
        $this->moip->setEnvironment('test');
        $this->moip->setCredential(['key' => 'XYO36IZJGAC7SYZURZ8A4SAGMJ6TTKTU0FG4V5NN', 'token' => 'DS60UI87KBYA9QW7HPLZLVNFSQ2KSDZA']);

        $this->mount();
    }


    function mount(){
        $user = Auth::user();

        $this->moip->setUniqueID(generate_key())->setValue($this->cart['subtotal'])->setAdds($this->cart['price_freight']);

        $this->moip->setPayer(['name' => $user->name . ' ' . $user->lastname, 'email' => $user->email, 'payerId' => $user->id, 'billingAddress' => ['address' => $this->getAddress()->public_place, 'number' => $this->getAddress()->number, 'complement' => $this->getAddress()->complements, 'city' => $this->getAddress()->city, 'neighborhood' => $this->getAddress()->neighborhood, 'state' => $this->getAddress()->state, 'country' => 'BR', 'zipCode' => $this->getAddress()->zip_code, 'phone' => $user->phone]]);
        $this->moip->setReason('Compra de produtos efetuada na plataforma Pop Martin');
        $this->moip->addPaymentWay('creditCard')->addPaymentWay('billet');
        $this->moip->setBilletConf(date('d/m/Y', strtotime("+3 days",strtotime(date('Y-m-d')))), false, ["Primeira linha", "Segunda linha", "Terceira linha"], url('imagem/pop/logo-popmartin.png'));
        $this->moip->addMessage('Produtos sendo comprados: ' . $this->getStringProducts());
        $this->moip->setReturnURL(url('accont/payment/callback'));
        $this->moip->setNotificationURL(url('accont/order/notification'));
        $this->moip->addComission('Comissão de venda Pop Matin', 'dev@asiw.com.br', $this->getStore()->comission, true, false);
        $this->moip->setReceiver($this->getStore()->salesman->moip);
        $this->moip->addParcel('1', '6', null, true);
        $this->moip->validate('Identification');
        $this->moip->send();
        $this->endpoint = isset($this->moip->getAnswer()->payment_url) ? $this->moip->getAnswer()->payment_url : null;
    }

    public function getAddress(){
        return Adress::find($this->address['id']);
    }

    public function getEndpoint(){
        return $this->endpoint;
    }

    public function getStringProducts(){
        $string = '';
        foreach($this->cart['products'] as $product){
            $string .= '[' .  $product['name'] . "] | "
                . ' quantidade = ' . $product['qtd'] . " | "
                . ' Valor unitário = ' . real($product['price_unit']) . " | "
                . ' total = ' . real($product['subtotal']) . " | ------------";
        }
        return $string;
    }

    public function getStore(){
        return Store::where('slug', '=', $this->cart['slug'])->first();
    }
}
