<?php
/**
 * Created by PhpStorm.
 * User: douglas
 * Date: 01/09/18
 * Time: 09:47
 */

namespace App\Services;

use PhpQuery\phpQuery;
use SimpleXMLElement;

class CorreiosService
{

   protected $client;

    const FRETE_URL    = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';
    const CEP_URL      = 'http://www.buscacep.correios.com.br/sistemas/buscacep/resultadoBuscaCepEndereco.cfm';
    const RASTREIO_URL = 'https://www2.correios.com.br/sistemas/rastreamento/ctrl/ctrlRastreamento.cfm?';

    public function __construct(\GuzzleHttp\Client $client){
        $this->client = $client;
    }

    public function zip_code($cep){
        $res = $this->client->post(self::CEP_URL, [
            'form_params' => [
                'relaxation' => $cep,
                'tipoCEP' => 'ALL',
                'semelhante' => 'N'
            ]
        ]);
        $html = $res->getBody()->getContents();
        phpQuery::newDocumentHTML($html, $charset = 'utf-8');

        $result = [];
        foreach (phpQuery::pq('tr') as $index => $tr){
            if($index > 0){
                $data['logradouro'] = trim(phpQuery::pq($tr)->find('td:eq(0)')->html());
                $data['bairro'] = trim(phpQuery::pq($tr)->find('td:eq(1)')->html());
                $data['zip_code'] = trim(phpQuery::pq($tr)->find('td:eq(3)')->html());
                list($city, $state) = explode('/', trim(phpQuery::pq($tr)->find('td:eq(2)')->html()));
                $data['cidade'] = $city;
                $data['uf'] = $state;
                array_push($result, $data);
            }
        }
        return $result;
    }

    private static $tipos = array(
        'sedex'          => '04014',
        'sedex_a_cobrar' => '40045',
        'sedex_10'       => '40215',
        'sedex_hoje'     => '40290',
        'pac'            => '04510',
        'pac_contrato'   => '04669',
        'sedex_contrato' => '04162',
        'esedex'         => '81019',
    );

    public static function getTipos()
    {
        return self::$tipos;
    }

    /**
     * Verifica se � uma solicita��o de varios $tipos
     *
     * @param $valor string
     * @return boolean
     */
    public static function getTipoIsArray($valor)
    {
        return count(explode(",", $valor)) > 1 ?: false;
    }

    /**
     * @param $valor string
     * @return string
     */
    public static function getTipoIndex($valor)
    {
        return array_search($valor, self::getTipos());
    }

    /**
     * Retorna todos os c�digos em uma linha
     *
     * @param $valor string
     * @return string
     */
    public static function getTipoInline($valor)
    {
        $explode = explode(",", $valor);
        $tipos   = array();

        foreach ($explode as $value)
        {
            $tipos[] = self::$tipos[$value];
        }

        return implode(",", $tipos);
    }

    public function frete($dados){
        $tipos = self::getTipoInline($dados['tipo']);

        $formatos = array(
            'caixa'    => 1,
            'rolo'     => 2,
            'envelope' => 3,
        );

        $dados['tipo']    = $tipos;
        $dados['formato'] = $formatos[$dados['formato']];
        /* dados[tipo]
          04014 SEDEX Varejo
          40045 SEDEX a Cobrar Varejo
          40215 SEDEX 10 Varejo
          40290 SEDEX Hoje Varejo
          04510 PAC Varejo
         */

        /*
          1 � Formato caixa/pacote
          2 � Formato rolo/prisma
          3 - Envelope
         */
        $dados['cep_destino'] = preg_replace("/[^0-9]/", '', $dados['cep_destino']);
        $dados['cep_origem']  = preg_replace("/[^0-9]/", '', $dados['cep_origem']);

        $params = array(
            'nCdEmpresa'          => (isset($dados['empresa']) ? $dados['empresa'] : ''),
            'sDsSenha'            => (isset($dados['senha']) ? $dados['senha'] : ''),
            'nCdServico'          => $dados['tipo'],
            'sCepOrigem'          => $dados['cep_origem'],
            'sCepDestino'         => $dados['cep_destino'],
            'nVlPeso'             => $dados['peso'],
            'nCdFormato'          => $dados['formato'],
            'nVlComprimento'      => $dados['comprimento'],
            'nVlAltura'           => $dados['altura'],
            'nVlLargura'          => $dados['largura'],
            'nVlDiametro'         => $dados['diametro'],
            'sCdMaoPropria'       => (isset($dados['mao_propria']) && $dados['mao_propria'] ? 'S' : 'N'),
            'nVlValorDeclarado'   => (isset($dados['valor_declarado']) ? $dados['valor_declarado'] : 0),
            'sCdAvisoRecebimento' => (isset($dados['aviso_recebimento']) && $dados['aviso_recebimento'] ? 'S' : 'N'),
            'sDtCalculo'          => date('d/m/Y'),
            'StrRetorno'          => 'xml'

        );

        $response = $this->client->request('GET', self::FRETE_URL,[
            'query' => $params
        ]);

        $xml = new SimpleXMLElement($response->getBody()->getContents());

        $resultado   = $xml->cServico;

        if (!is_array($resultado))
            $resultado = array($resultado);

        $dados = array();

        foreach ($resultado as $consulta)
        {
            $consulta = (array) $consulta;

            $dados[] = array(
                'codigo'             => $consulta['Codigo'],
                'valor'              => (float) str_replace(',', '.', $consulta['Valor']),
                'prazo'              => (int) str_replace(',', '.', $consulta['PrazoEntrega']),
                'mao_propria'        => (float) str_replace(',', '.', $consulta['ValorMaoPropria']),
                'aviso_recebimento'  => (float) str_replace(',', '.', $consulta['ValorAvisoRecebimento']),
                'valor_declarado'    => (float) str_replace(',', '.', $consulta['ValorValorDeclarado']),
                'entrega_domiciliar' => ($consulta['EntregaDomiciliar'] === 'S' ? true : false),
                'entrega_sabado'     => ($consulta['EntregaSabado'] === 'S' ? true : false),
                'erro'               => array('codigo' => (real) $consulta['Erro'], 'mensagem' => $consulta['MsgErro']),
            );
        }

        if (self::getTipoIsArray($tipos) === false)
        {
            return isset($dados[0]) ? $dados[0] : [];
        }

        return $dados;
    }

    public function rastrear($codigo)
    {
        /*$curl = new Curl;

        $html = $curl->simple('http://websro.correios.com.br/sro_bin/txect01$.QueryList?P_LINGUA=001&P_TIPO=001&P_COD_UNI='.$codigo);*/

        $html = $this->client->post(self::RASTREIO_URL, [
            'form_params' => [
                'objetos' => $codigo
            ]
        ]);
        phpQuery::newDocumentHTML($html, $charset = 'utf-8');

        $rastreamento = array();
        $c = 0;

        foreach(phpQuery::pq('tr') as $tr){$c++;
            if(count(phpQuery::pq($tr)->find('td')) == 3 && $c > 1)
                $rastreamento[] = array('data'=>phpQuery::pq($tr)->find('td:eq(0)')->text(),'local'=>phpQuery::pq($tr)->find('td:eq(1)')->text(),'status'=>phpQuery::pq($tr)->find('td:eq(2)')->text());

            if(count(phpQuery::pq($tr)->find('td')) == 1 && $c > 1)
                $rastreamento[count($rastreamento)-1]['encaminhado'] = phpQuery::pq($tr)->find('td:eq(0)')->text();
        }

        if(!count($rastreamento))
            return false;

        return $rastreamento;
    }

}