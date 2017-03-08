<?php

namespace App\Http\Controllers\Accont;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConnectAppMoipController extends Controller {
    //  https://connect-sandbox.moip.com.br/oauth/authorize?response_type=code&client_id=APP-6IWY5RHHDCG5&redirect_uri=http://popmartin.dev/appmoip/connect&scope=RECEIVE_FUNDS,REFUND,MANAGE_ACCOUNT_INFO
    // 93ce0244661d599d1c2460b06df2868e13a638bb
    private $code, $fields;
    const CONNECT_NAME= "DevAsiw";
    const CONNECT_APP_ID = "APP-6IWY5RHHDCG5";
    const CONNECT_APP_TOKEN = "2fd36bc6c167442a9fa7f6edf09c0c3b_v2";
    const CONNECT_APP_SECRET = "93188a4586a54c53bc17ad61b8e83bb0";
    const CONNECT_ENDPOINT_AUTHORIZE = "https://connect-sandbox.moip.com.br/oauth/authorize";
    const CONNECT_ENDPOINT_TOKEN = "https://connect-sandbox.moip.com.br/oauth/token";
    const CONNECT_URL_RETURN = "http://popmartin.dev/appmoip/connect";

    public function show(Request $request){
        $this->code = $request->code;

        ($this->code ? $this->createToken() : $this->updateToken());


        return view('accont.appmoip_connect');
    }

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

    private function updateToken(){
        $this->fields = [
            'refresh_token' => self::CONNECT_APP_TOKEN,
            'grant_type' => 'refresh_token'
        ];
        $this->curl();
    }

    private function curl(){
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, self::CONNECT_ENDPOINT_TOKEN);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, [
            'Accept: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode($this->code),
            'Cache-Control: no-cache'
        ] );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $this->fields );
        $data = curl_exec( $ch );
        curl_close( $ch );

        dd($data, base64_encode($this->code));
    }
}
