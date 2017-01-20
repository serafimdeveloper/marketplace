@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <h2>Detalhe do pedido</h2>
        <div class="padding10-20">
            <p class="fontem-12">Status: <span class="c-orange fontw-600">aguardando pagamento</span></p>

            <table class="table table-action">
                <thead>
                <tr>
                    <th class="t-small">ID</th>
                    <th>Produto</th>
                    <th class="t-small">Quantidade</th>
                    <th class="t-medium">Loja</th>
                    <th class="t-small">Valor</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>1</td>
                    <td><a href="/loja/nome/categoria/produto" target="_blank">produto X</a></td>
                    <td>1</td>
                    <td><a href="/loja/juca" target="_blank">Juca</a></td>
                    <td class="t-active bold"><span class="fontem-12">R$14,90</span></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td><a href="/loja/nome/categoria/produto" target="_blank">produto Y</a></td>
                    <td>1</td>
                    <td><a href="/loja/juca" target="_blank">Juca</a></td>
                    <td class="t-active bold"><span class="fontem-12">R$27,90</span></td>
                </tr>
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
                    <th>de</th>
                    <th>para</th>
                    <th class="t-small">Valor</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>PAC</td>
                    <td>endereço 1</td>
                    <td>endereço 2</td>
                    <td class="t-active bold"><span class="fontem-12">R$14,90</span></td>
                </tr>
                <tr>
                    <td>PAC</td>
                    <td>endereço 1</td>
                    <td>endereço 2</td>
                    <td class="t-active bold"><span class="fontem-12">R$14,90</span></td>
                </tr>
                <tr>
                    <td colspan="3">Total</td>
                    <td class="t-active bold"><span class="fontem-18 fontw-800">R$29,80</span></td>
                </tr>
                </tbody>
            </table>
            <p class="fontem-26">Total do pedido <span class="fl-right c-green fontw-900">R$74,80</span></p>
        </div>
    </section>
    <div class="clear-both"></div>
@endsection
