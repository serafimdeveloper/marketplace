<html>
<head>
    <title>Etiqueta de pedido para correios</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ url('/frontend/css/bootstrap.css') }}">
    <style>
        .destinatario{position: relative;}
        .destinatario img{width: 15%;position: absolute; right: 50px; top: 20px;}
        table{width: 100%;border: 1px solid #888888;font-size: 1.2em;padding: 10px;text-align: left;}
        table tr .th{width: 16%;text-align: right;}
        table td{padding: 7px 5px;}
        .tesoura{padding: 10px 0;border-bottom: 1px dashed #555555;position: relative;}
        .tesoura span{position: absolute; left: 0;bottom: -11px;font-size: 1.4em;color:#555555;}
        .fontw-500{font-weight: bold;}
    </style>
</head>
<body>
<div class="content">
    <div class="destinatario" style="font-size: 14px !important;">
        <table>
            <tr>
                <td class="th">Destinatário:</td>
                <td style="font-weight: 900 !important;"><strong>{{ mb_strtoupper($address['receiver']->name)}}</strong></td>
            </tr>
            <tr>
                <td class="th">Rua:</td>
                <td>{{$address['receiver']->public_place}}</td>
            </tr>
            <tr>
                <td class="th">Número:</td>
                <td>{{$address['receiver']->number}}</td>
            </tr>
            <tr>
                <td class="th">Complemento:</td>
                <td>{{$address['receiver']->complements}}</td>
            </tr>
            <tr>
                <td class="th">Bairro:</td>
                <td>{{$address['receiver']->neighborhood}}</td>
            </tr>
            <tr>
                <td class="th">Cidade:</td>
                <td>{{$address['receiver']->city}}</td>
            </tr>
            <tr>
                <td class="th">Cep:</td>
                <td>{{$address['receiver']->zip_code}}</td>
            </tr>
            <tr>
                <td class="th">UF:</td>
                <td>{{$address['receiver']->state}}</td>
            </tr>
        </table>
        <img src="{{ url('image/logo-popmartin.png') }}" alt="[Pop Martin]" title="Pop Martin">
    </div>

    <p class="tesoura"><span class="fa fa-scissors"></span> </p>
    <div class="destinatario" style="font-size: 10px !important;">
        <table>
            <tr>
                <td class="th">Remetente:</td>
                <td class="fontw-500" colspan="3">{{$store->salesman->user->name}} {{$store->salesman->user->last_name}} ({{$store->name}})</td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td class="th">Rua:</td>
                <td>{{$address['sender']->public_place}}</td>
                <td class="th">Número:</td>
                <td>{{$address['sender']->number}}</td>
                <td>Complemento:</td>
                <td>{{$address['sender']->complements}}</td>
            </tr>
            <tr>
                <td class="th">Bairro:</td>
                <td>{{$address['sender']->neighborhood}}</td>
                <td class="th">Cidade:</td>
                <td>{{$address['sender']->city}}</td>
                <td class="th">UF:</td>
                <td>{{$address['sender']->state}}</td>
            </tr>
            <tr>
                <td class="th">Cep:</td>
                <td>{{$address['sender']->zip_code}}</td>
                <td colspan="4"></td>
            </tr>
        </table>
    </div>
    <p class="tesoura"><span class="fa fa-scissors"></span> </p>
</div>
</body>
</html>