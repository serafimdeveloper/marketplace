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
        $this->moip->setEnvironment(env('MOIP_ENVIRONMENT'));
        $this->moip->setCredential(['key' => env('MOIP_KEY'), 'token' => env('MOIP_TOKEN')]);
        $this->mount();
    }

    function mount(){
        $user = Auth::user();

        $this->moip->setUniqueID($this->order->key)->setValue($this->order->amount);
        $this->moip->setPayer(['name' => $user->name . ' ' . $user->lastname, 'email' => $user->email, 'payerId' => $user->id, 'billingAddress' => ['address' => $this->address->public_place, 'number' => $this->address->number, 'complement' => $this->address->complements, 'city' => $this->address->city, 'neighborhood' => $this->address->neighborhood, 'state' => $this->address->state, 'country' => 'BR', 'zipCode' => (INT) $this->address->zip_code, 'phone' => $user->phone]]);
        $this->moip->setReason('Compra efetuada na plataforma PopMartin. Vendedor: ' . $this->store->name);
        $this->moip->addPaymentWay('creditCard')->addPaymentWay('billet');
        $this->moip->setBilletConf(date('d/m/Y', strtotime("+3 days",strtotime(date('Y-m-d')))), false, ["Popmatin.com.br", env('MAIL_USERNAME'), ""], url('imagem/pop/logo-popmartin.png'));
        $this->moip->addMessage('Produtos sendo comprados: ' . $this->getStringProducts());
        $this->moip->setReturnURL(url('accont/payment/callback'));
        $this->moip->setNotificationURL(url('api/notification/moip/nasp'));
        $this->moip->addComission('Comissão de venda Pop Matin', env('MOIP_COMISSION'), ($this->store->salesman->comission ? $this->store->salesman->comission : env('MOIP_COMISSION_DEFAULT')), true, true);
        $this->moip->setReceiver($this->store->salesman->moip);
        $this->moip->addParcel('1', '12', null, true);
        $this->moip->validate('Identification');
        $this->moip->send();
        $this->endpoint = isset($this->moip->getAnswer()->payment_url) ? $this->moip->getAnswer()->payment_url : null;
    }

    public function getQueryParcel(){

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

    private function send_email($type, $template, $data, $subject){
        $data['email'] = ($type === 'client') ? $data['user']->email : $data['store']->salesman->user->email;
        $data['name'] = ($type === 'client') ? $data['user']->name : $data['store']->salesman->user->name;
        send_mail($template, $data, $subject);
    }
}
