<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 29/03/2017
 * Time: 19:20
 */

namespace App\Services;

use App\Model\Request;
use App\Package\Moip\lib\Moip;
use App\Package\Moip\lib\MoIPClient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MoipServices {
    private $instruction;
    private $order;
    private $moip;
    private $billetUrl;
    private $address;
    private $store;
    private $endpoint;

    /**
     * MoipServices constructor.
     * @param $moipClient - true para usa MoipClient ou null para usa Moip
     * @param null $endpoint default '/ws/alpha/EnviarInstrucao/Unica'
     */
    function __construct($moipClient = null, $endpoint = null){
        $endpoint = ($endpoint ? $endpoint : '/ws/alpha/EnviarInstrucao/Unica');
        $this->moip = ($moipClient ? new MoIPClient : new Moip);
        $this->endpoint = env('MOIP_URL') . $endpoint;
    }

    public function setConstruct($moipClient, $endpoint){
        $this->__construct($moipClient, $endpoint);
    }

    /**
     * Setar ordem de pedido para Enviar instrução Moip
     * @param $order
     */
    public function setOrderMoip($order){
        $this->order = $order;
        $this->address = $this->order->adress;
        $this->store = $order->store;
    }

    /**
     * Reorna o endpoint de consulta
     * @return null
     */
    public function getEndpoint(){
        return $this->endpoint;
    }

    /**
     * Retorna a url para pagamento de boleto
     * @return mixed
     */
    public function getBilletUrl(){
        return $this->billetUrl;
    }

    /**
     * Retorna o token de pagamento gerado após a instrução única
     * @return null
     */
    public function getToken(){
        return $this->moip->getAnswer()->token ? $this->moip->getAnswer()->token : null;
    }

    /**
     * Retorna instrução criada pelo instrução única
     * @return mixed
     */
    public function getInstruction(){
        return $this->instruction;
    }

    /**
     * Retorna Ordem informada para instrução
     * @return mixed
     */
    public function getOrder(){
        return $this->order;
    }

    public function getQueryParcel(){
        $this->moip->queryParcel();
    }

    /**
     * Enviar instrução única Moip
     * @param $order
     */
    function uniqueInstruction($order){
        $this->setOrderMoip($order);
        $value_products = $this->order->amount - $this->order->price_freight;
        $user = Auth::user();
        $this->moip->setEnvironment(env('MOIP_ENVIRONMENT'));
        $this->moip->setCredential(['key' => env('MOIP_KEY'), 'token' => env('MOIP_TOKEN')]);
        $this->moip->setUniqueID($this->order->key)->setValue($value_products)->setAdds($this->order->price_freight);
        $this->moip->setPayer(['name' => $user->name . ' ' . $user->lastname, 'email' => $user->email, 'payerId' => $user->id, 'billingAddress' => ['address' => $this->address->public_place, 'number' => $this->address->number, 'complement' => $this->address->complements, 'city' => $this->address->city, 'neighborhood' => $this->address->neighborhood, 'state' => $this->address->state, 'country' => 'BR', 'zipCode' => (INT)$this->address->zip_code, 'phone' => $user->phone]]);
        $this->moip->setReason('Compra efetuada na plataforma PopMartin. Vendedor: ' . $this->store->name);
        $this->moip->addPaymentWay('creditCard')->addPaymentWay('billet');
        $this->moip->setBilletConf(date('d/m/Y', strtotime("+3 days", strtotime(date('Y-m-d')))), false, ["Popmatin.com.br", env('MAIL_USERNAME'), ""], url('imagem/pop/logo-popmartin.png'));
        $this->moip->addMessage('Produtos comprado na plataforma Popmartin');
        $this->moip->setReturnURL(url('accont/payment/callback'));
        $this->moip->setNotificationURL(url('api/notification/moip/nasp'));
        $this->moip->addComission('Venda na plataforma popmartin', env('MOIP_COMISSION'), ($this->store->salesman->comission ? $this->store->salesman->comission : env('MOIP_COMISSION_DEFAULT')) - 7.3, true, false);
        $this->moip->setReceiver($this->store->salesman->moip);
        $this->moip->addParcel('1', '10', null, true);
        $this->moip->validate('Identification');
        $this->moip->send();

        $this->billetUrl = isset($this->moip->getAnswer()->payment_url) ? $this->moip->getAnswer()->payment_url : null;
        $this->instruction = $this->moip->getXML();
    }


    /**
     * Cunsulta instrução
     * @param null $orderId
     */
    public function consultIntruction($orderId = null){
        $this->setOrderMoipClient((int)$orderId);
        $order_moip = new MoIPClient;
        $consult_result = $order_moip->curlGet(env('MOIP_TOKEN') . ":" . env('MOIP_KEY'), $this->endpoint . $this->order->moip->token);
        $xml = simplexml_load_string($consult_result->xml);
        if($xml){
            $this->instruction = $xml->RespostaConsultar;
        }
    }

    /**
     * Status da instrução na consulta
     * @param null $orderId
     */
    public function checkStatusInstruction($orderId = null){
        $this->consultIntruction($orderId);
        $status = $this->order->request_status_id;
        if($status < 3){
            if(isset($this->instruction->Autorizacao)){
                $auth = $this->instruction->Autorizacao;
                $status = (string)$auth->Pagamento->Status;
                if($status == 'Autorizado'){
                    $status = 3;
                    $this->order->products->each(function($product){
                        if($product->pivot->quantity > $product->quantity){
                            $data = ['email' => $this->order->store->salesman->user->email, 'store' => $this->order->store,'order' => $this->order, 'product' => $product];
                            send_mail('emails.merchants_lackofproduct', $data, 'Falta de produto em pedido', $this->order->store->name);
                        }else{
                            $product->decrement('quantity', $product->pivot->quantity);
                        }
                    });
                    $data = ['email' => $this->order->user->email, 'user' => $this->order->user, 'store' => $this->order->store, 'products' => $this->order->products, 'request' => $this->order];
                    send_mail('emails.customer_confirmation', $data, 'Pagamento efetuado com sucesso ' . $this->order->user->name);
                    $data['email'] = $this->order->store->salesman->user->email;
                    send_mail('emails.merchants_confirmation', $data, 'Pagamento recebido ' . $this->order->store->name);
                }elseif($status == 'Cancelado'){
                    $status = 6;
                }else if($status == 'Iniciado' || $status = 'EmAnalise' || $status = 'boletoEmpresso'){
                    $status = 1;
                }
                $this->updateOrder($status);
            };
        }
    }

    /**
     * Checar várias intruções com base na regra
     * @param array $where
     */
    public function checkStatusInstructions(array $where){
        $order = Request::where($where)->get();
        $order->each(function($order){
            $this->checkStatusInstruction($order->id);
        });
    }

    /*********************************************************
     * *********** MÉTODOS PRIVADOS *************************
     * ******************************************************/
    /**
     * Atualizar Pedido de acordo com cunsulta de instrução
     * @param $status
     */
    private function updateOrder($status){
        $cancellation = ($status == 6 ? Carbon::now() : null);
        dd($this->instruction->Autorizacao);
        $amount_interest = ((float) $this->instruction->Autorizacao->Pagamento->TotalPago - $this->order->amount);
        $this->order->fill([
            'request_status_id' => $status,
            'amount_interest' => $amount_interest,
            'rate_moip' => (float) $this->instruction->Autorizacao->Pagamento->TaxaMoIP,
            'payment_reference' => (string) $this->instruction->Autorizacao->Pagamento->FormaPagamento,
            'payment_institution' => (string) $this->instruction->Autorizacao->Pagamento->InstituicaoPagamento,
            'commission_amount' => (float) $this->instruction->Autorizacao->Pagamento->Comissao->Valor,
            'number_installments' => (string) $this->instruction->Autorizacao->Pagamento->Parcela->TotalParcelas,
            'cancellation_date' => $cancellation
        ])->save();
        $this->order->moip->fill([
            'codeMoip' => (string) $this->instruction->Autorizacao->Pagamento->CodigoMoIP
        ])->save();
    }

    /**
     * Setar ordem de pedido
     * @param $order
     */
    private function setOrderMoipClient($order){
        if(is_int($order)){
            $this->order = Request::find($order);
        }else{
            $this->order = Request::where('key', '=' . $order)->first();
        }
    }
}