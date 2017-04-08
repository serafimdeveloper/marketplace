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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class MoipServices {
    private $instruction;
    private $order;

    public function getInstruction(){
        return $this->instruction;
    }

    public function getOrder(){
        return $this->order;
    }

    public function consultIntruction($orderId = null){
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
                    $this->order->products->each(function($product){
                        if($product->quantity < $this->order->products->pivot->quantity){
                            $data = ['email' => $this->order->store->salesman->user->email, 'store' => $this->order->store,'request' => $this->order];
                            send_mail('emails.merchants_lackofproduct', $data, 'Falta de produto em pedido', $this->order->store->name);
                        }else{
                            $product->decrement('quantity', $this->order->products->pivot->quantity);
                        }

                    });
                    $data = ['email' => $this->order->user->email, 'user' => Auth::user(), 'store' => $this->order->store, 'products' => $this->order->products, 'request' => $this->order];
                    send_mail('emails.customer_confirmation', $data, 'Pagamento efetuado com sucesso ' . Auth::user()->name);
                    $data['email'] = $this->order->store->salesman->user->email;
                    send_mail('emails.merchants_confirmation', $data, 'Pagamento recebido ' . $this->order->store->name);
                }elseif($status == 'Cancelado'){
                    $this->order->fill(['request_status_id' => 6])->save();
                }else if($status == 'Iniciado' || $status = 'EmAnalise' || $status = 'boletoEmpresso'){
                    $this->order->fill(['request_status_id' => 1])->save();
                }

            };
        }
    }

    public function checkStatusInstructions(){
        $order = Request::where('request_status_id', '<', 3)->get();
        $order->each(function($order){
            $this->checkStatusInstruction($order->id);
            sleep(5000);
        });
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