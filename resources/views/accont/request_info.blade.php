@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Detalhe do pedido</h1>
        </header>
        <div class="padding10-20">
            <p>
                <span class="fontw-500">Status:</span> <span class="c-orange fontw-600">aguardando pagamento</span><br>
                <span class="fontw-500">Pedido N°:</span> 125668<br>
                <span class="fontw-500">Data:</span> hoje às 13:25:86<br>
                <span class="fontw-500">Loja:</span> Pop Martin
            </p>

            <table class="table table-action">
                <thead>
                <tr>
                    <th class="t-medium" style="width: 100px;"></th>
                    <th>Produto</th>
                    <th class="t-small">Quantidade</th>
                    <th class="t-medium">Valor unitário</th>
                    <th class="t-small">Valor total</th>
                </tr>
                </thead>

                <tbody>
                @for ($i = 0; $i < 3; $i++)
                    <tr>
                        <td><img src="{{ url('image/img-exemple.jpg') }}"></td>
                        <td><a href="/loja/nome/categoria/produto" class="fontem-12" target="_blank">produto X</a></td>
                        <td>1</td>
                        <td><span class="fontem-12">R$14,90</span></td>
                        <td class="t-active bold"><span class="fontem-12">R$14,90</span></td>
                    </tr>
                @endfor
                <tr>
                    <td colspan="4">Total</td>
                    <td class="t-active bold"><span class="fontem-18 fontw-800">R$42,80</span></td>
                </tr>
                </tbody>
            </table>

            <table class="table table-action">
                <thead>
                <tr>
                    <th class="t-small">Frete</th>
                    <th>destino</th>
                    <th class="t-small">Total</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>PAC</td>
                    <td>
                        <span>Maria da Silva Pereira</span><br>
                        <span>46560-000 (BA)</span><br>
                    </td>
                    <td class="t-active bold"><span class="fontem-12">R$14,90</span></td>
                </tr>
                </tbody>
            </table>
            <hr>
            <p class="fontem-22 fontw-500">Total do pedido <span class="fl-right c-green fontw-900">R$74,80</span></p>
        </div>
    </section>
    <div class="clear-both"></div>
@endsection
