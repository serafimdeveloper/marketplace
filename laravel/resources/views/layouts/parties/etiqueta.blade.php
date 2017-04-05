<html>
<head>
    <title>Etiqueta de pedido para correios</title>
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
                <td style="font-weight: 900 !important;"><strong>{{ mb_strtoupper($request->adress->name)}}</strong></td>
            </tr>
            <tr>
                <td class="th">Rua:</td>
                <td>{{$request->adress->public_place}}</td>
            </tr>
            <tr>
                <td class="th">Número:</td>
                <td>{{$request->adress->number}}</td>
            </tr>
            <tr>
                <td class="th">Complemento:</td>
                <td>{{$request->adress->complements}}</td>
            </tr>
            <tr>
                <td class="th">Bairro:</td>
                <td>{{$request->adress->neighborhood}}</td>
            </tr>
            <tr>
                <td class="th">Cidade:</td>
                <td>{{$request->adress->city}}</td>
            </tr>
            <tr>
                <td class="th">Cep:</td>
                <td>{{$request->adress->zip_code}}</td>
            </tr>
            <tr>
                <td class="th">UF:</td>
                <td>{{$request->adress->state}}</td>
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
                <td>{{$store->adress->public_place}}</td>
                <td class="th">Número:</td>
                <td>{{$store->adress->number}}</td>
                <td>Complemento:</td>
                <td>{{$store->adress->complements}}</td>
            </tr>
            <tr>
                <td class="th">Bairro:</td>
                <td>{{$store->adress->neighborhood}}</td>
                <td class="th">Cidade:</td>
                <td>{{$store->adress->city}}</td>
                <td class="th">UF:</td>
                <td>{{$store->adress->state}}</td>
            </tr>
            <tr>
                <td class="th">Cep:</td>
                <td>{{$store->adress->zip_code}}</td>
                <td colspan="4"></td>
            </tr>
        </table>
    </div>
    <p class="tesoura"><span class="fa fa-scissors"></span> </p>
</div>
</body>
</html>