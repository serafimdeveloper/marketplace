<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 29/03/2017
 * Time: 19:20
 */

namespace App\Services;

use App\Model\Request;
use App\Package\Moip\lib\MoIPClient;
use Illuminate\Support\Facades\Auth;

class MoipServices {
    private $instruction;
    private $orderKey;
    private $orderId;
    private $order;

    function __construct($orderId = null, $orderKey = null){
        $this->orderId = ($orderId ? $orderId : null);
        $this->orderKey = ($orderKey ? $orderKey : null);

    }

    public function getInstruction(){
        return $this->instruction;
    }
    public function getOrder(){
        return $this->order;
    }

    public function consultIntruction($orderId){
        $this->setOrder((int)$orderId);
        $order_moip = new MoIPClient;
        $consult_result = $order_moip->curlGet(env('MOIP_TOKEN') . ":" . env('MOIP_KEY'), env('MOIP_URL') . '/ws/alpha/ConsultarInstrucao/' . $this->order->moip->token);
        $xml = simplexml_load_string($consult_result->xml);
        $this->instruction = $xml->RespostaConsultar;
    }

    public function checkStatusInstruction($orderId = null){
        $this->consultIntruction($orderId);
        if($this->order->request_status_id < 3){
            if($this->instruction->Autorizacao){
                $auth = $this->instruction->Autorizacao;
                $status = (string)$auth->Pagamento->Status;
                if($status == 'Autorizado'){
                    $this->order->fill(['request_status_id' => 3])->save();
                    $data = ['user' => Auth::user(), 'store' => $this->order->store, 'products' => $this->order->products, 'request' => $this->order];
//                    send_mail('emails.customer_confirmation', $data, 'Pagamento efetuado com sucesso ' . $this->order->store->name);
//                    send_mail('emails.merchants_confirmation', $data, 'Pagamento recebido ' . Auth::user()->name);
                }elseif($status == 'Cancelado'){
                    $this->order->fill(['request_status_id' => 3])->save();
                }

            };
        }
    }

    /*********************************************************
     * *********** MÉTODOS PRIVADOS *************************
     * ******************************************************/
    /**
     * Setar ordem de pedido
     * @param $order
     */
    private function setOrder($order){
        if(is_int($order)){
            $this->order = Request::find($order);
        }else{
            $this->order = Request::where('key', '=' . $order)->first();
        }
    }
}