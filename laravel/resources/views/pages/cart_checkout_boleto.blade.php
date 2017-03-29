@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="pop-title">
            <h1>Pedido de compra</h1>
        </div>
        <br>
        <div class="bg-graylightextreme padding20 radius">
            <h2>Pedido número M20171382</h2>
            <span class="fontem-14 c-pop">R$ 39,90</span></p>
        </div>
        <br>
        <div class="bg-graylightextreme padding20 radius">
            <h3>Código de barras:</h3>
            <div class="content">
                <span>Copie e cole a linha digitável a seguir no site ou aplicativo do seu banco</span><br>
                <div class="dp-inblock fontem-14" style="border: 1px solid #555555; padding: 10px 40px;">
                    sdfq342wdc8-q7d0-pqv7q2g108db1pd12
                </div>
            </div>
        </div>
        <br>
        <div class="txt-center">
            <a id="payBillet" class="btn btn-popmartin" href="javascript:payBillet();">
                Imprimir Boleto
            </a>
        </div>
    </section>
@endsection
