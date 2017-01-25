<html>
<head>
    <title>Etiqueta de pedido para correios</title>
    <link rel="stylesheet" href="{{ url('/frontend/css/bootstrap.css') }}">
    <style>
        .destinatario{position: relative;}
        .destinatario img{width: 15%;position: absolute; right: 50px; bottom: 30px;}
        table{width: 100%;border: 1px solid #888888;font-size: 1.2em;padding: 10px;text-align: left;}
        table tr .th{width: 16%;text-align: right;}
        table td{padding: 7px 5px;}
        .tesoura{padding: 10px 0;border-bottom: 1px dashed #555555;position: relative;}
        .tesoura span{position: absolute; left: 0;bottom: -11px;font-size: 1.4em;color:#555555;}
    </style>
</head>
<body>
<div class="content">
    <div class="destinatario">
        <table>
            <tr>
                <td class="th">Destinatário:</td>
                <td class="fontw-500">Luana Lopoes da Silva</td>
            </tr>
            <tr>
                <td class="th">Rua:</td>
                <td>Francisco de Souaz Lima</td>
            </tr>
            <tr>
                <td class="th">Número:</td>
                <td>313</td>
            </tr>
            <tr>
                <td class="th">Bairro:</td>
                <td>Alto da Cruz</td>
            </tr>
            <tr>
                <td class="th">Cidade:</td>
                <td>Floriano</td>
            </tr>
            <tr>
                <td class="th">Cep:</td>
                <td>64803-265</td>
            </tr>
            <tr>
                <td class="th">UF:</td>
                <td>PI</td>
            </tr>
        </table>
        <img src="{{ url('image/logo-popmartin.png') }}" alt="[Pop Martin]" title="Pop Martin">
    </div>

    <p class="tesoura"><span class="fa fa-scissors"></span> </p>
    <div class="destinatario">
        <table>
            <tr>
                <td class="th">Remetente:</td>
                <td class="fontw-500">Luana Lopoes da Silva</td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td class="th">Rua:</td>
                <td>Francisco de Souaz Lima</td>
                <td class="th">Número:</td>
                <td>313</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td class="th">Bairro:</td>
                <td>Alto da Cruz</td>
                <td class="th">Cidade:</td>
                <td>Floriano</td>
                <td class="th">UF:</td>
                <td>PI</td>
            </tr>
            <tr>
                <td class="th">Cep:</td>
                <td>64803-265</td>
                <td colspan="4"></td>
            </tr>
        </table>
    </div>
    <p class="tesoura"><span class="fa fa-scissors"></span> </p>
</div>
</body>
</html>