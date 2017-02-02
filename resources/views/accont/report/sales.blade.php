@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Vendas / Comissões</h1>
        </header>
        <form class="form-modern searh_store" action="javascript:void(0)">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <label>
                <input type="search" class="jq-input-search" name="user_name" placeholder="Pesquisar pedido pelo código">
            </label>
        </form>
        <table id="jq-search-table-result" class="table table-action">
            <thead>
            <tr>
                <th class="t-medium">Pedido</th>
                <th class="t-medium">Data</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th class="t-small">Status</th>
                <th class="t-small">Valor</th>
                <th class="t-small">Comissão</th>
                <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
            </tr>
            </thead>

            <tbody>
            @for($i = 0;$i < 3; $i++)
                <tr>
                    <td>#lbcsd769yqob</td>
                    <td>Ontem às 12:45:85</td>
                    <td>Antônio Alvez</td>
                    <td>Loja do juca</td>
                    <td class="t-active">concluída</td>
                    <td>R$58,00</td>
                    <td>R$5.80</td>
                    <td class="txt-center">
                        <a href="javascript:void(0)" class="t-btn t-popmartin jq-info-sales" data-sales="{{$i}}">detalhes</a>
                    </td>
                </tr>
            @endfor
            </tbody>
        </table>
    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_sales_info')
@endsection
