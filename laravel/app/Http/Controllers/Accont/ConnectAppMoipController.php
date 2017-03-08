<?php

namespace App\Http\Controllers\Accont;


use App\Http\Controllers\Controller;
use App\Model\ConnectSallesman;
use App\Repositories\Accont\ConnectSallesmanRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectAppMoipController extends Controller {

    private $code, $fields, $data, $connect, $result = false;

    const CONNECT_NAME= "DevAsiw";
    const CONNECT_APP_ID = "APP-6IWY5RHHDCG5";
    const CONNECT_APP_TOKEN = "2fd36bc6c167442a9fa7f6edf09c0c3b_v2";
    const CONNECT_APP_SECRET = "93188a4586a54c53bc17ad61b8e83bb0";
    const CONNECT_ENDPOINT_AUTHORIZE = "https://connect-sandbox.moip.com.br/oauth/authorize";
    const CONNECT_ENDPOINT_TOKEN = "https://connect-sandbox.moip.com.br/oauth/token";
    const CONNECT_URL_RETURN = "http://popmartin.dev/appmoip/connect";

    function __construct(ConnectSallesmanRepository $connect){
        $this->connect = $connect;
    }

    public function show(Request $request){
        $this->code = $request->code;
        ($this->code ? $this->createToken() : $this->updateToken());

        $result = $this->result;
        return view('accont.appmoip_connect', compact('result'));
    }

    /**
     * Parâmetros de criação de token de acesso para novo vendedor na plataforma
     */
    private function createToken(){
        $this->fields = [
            'client_id' => self::CONNECT_APP_ID,
            'client_secret' => self::CONNECT_APP_SECRET,
            'grant_type' => 'authorization_code',
            'code' => $this->code,
            'redirect_uri' => self::CONNECT_URL_RETURN,
        ];
        $this->curl();
    }

    /**
     * Parâmetros de atualização de acesso de vendedor na plataforma
     * @param $id
     */
    private function updateToken($id = null){
        if($id){
            $connect = $this->connect->get($id);
            $this->fields = [
                'refresh_token' => $connect->refresh_token,
                'grant_type' => 'refresh_token'
            ];
            $this->curl();
        }else{
            $connecties = $this->connect->all();
            foreach($connecties as $connect){
                $this->fields = [
                    'refresh_token' => $connect->refresh_token,
                    'grant_type' => 'refresh_token'
                ];
                $this->curl();
            }
        }
    }

    /**
     * Curl de chamada OAUTH padrão moip
     */
    private function curl(){
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, self::CONNECT_ENDPOINT_TOKEN);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, [
            'Accept: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode($this->code),
            'Cache-Control: no-cache'
        ] );
//        curl_setopt( $ch, CURLOPT_HEADER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $this->fields );
        $data = curl_exec( $ch );
        curl_close( $ch );
        if($data){
            $this->data = json_decode($data);
            if(isset($this->data->moipAccount)){
                $this->data->moipAccount_id = $this->data->moipAccount->id;
                unset($this->data->moipAccount);
                $this->crud();
            }
        }
    }

    private function crud(){
//        $connect = $this->connect->all(['*'], [], ['moipAccount_id' => $this->data->moipAccount_id]);
        $connect = ConnectSallesman::where('moipAccount_id' , '=', $this->data->moipAccount_id)->first();
        $this->data->salesman_id = Auth::user()->salesman->id;
        if(!isset($connect->id)){
            $this->result = $this->connect->store((array) $this->data);
        }else{
            $this->result = $this->connect->update((array) $this->data, $connect->id);
        }
    }
}
