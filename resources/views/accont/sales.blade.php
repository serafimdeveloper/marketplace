@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Minhas vendas</h1>
        </header>
        <table class="table table-action">
            <thead>
            <tr>
                <th class="t-small">Pedido</th>
                <th class="t-medium">Data</th>
                <th class="t-small">Valor</th>
                <th class="t-medium">Cliente</th>
                <th class="t-small">Status</th>
                <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
            </tr>
            </thead>

            <tbody>
            @for ($i = 0; $i < 5; $i++)
                <tr>
                    <td>#125875</td>
                    <td>Ontem às 15:16:02</td>
                    <td>R$ 25,00</td>
                    <td>Maria da Silva</td>
                    <td class="t-status t-active">concuído</td>
                    <td class="txt-center"><a href="/accont/salesman/sale/1" class="t-popmartin">detalhes</a></td>
                </tr>
                <tr>
                    <td>#125875</td>
                    <td>Ontem às 15:16:02</td>
                    <td>R$ 25,00</td>
                    <td>Maria da Silva</td>
                    <td class="t-status t-scheduled">esperando envio</td>
                    <td class="txt-center"><a href="/accont/salesman/sale/1" class="t-popmartin">detalhes</a></td>
                </tr>
            @endfor
            </tbody>
        </table>
    </section>
    <div class="clear-both"></div>
@endsection
