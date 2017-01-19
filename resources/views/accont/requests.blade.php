@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <h2>Meus pedidos</h2>
        <!-- TABLE -->
        <table class="table table-action">

            <thead>
            <tr>
                <th class="t-small">ID</th>
                <th class="t-medium">Data</th>
                <th class="t-medium">Valor</th>
                <th class="t-medium">Form de pagamento</th>
                <th class="t-medium">State</th>
                <th class="t-small"></th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>1</td>
                <td>27/09/2013</td>
                <td>R$25,00</td>
                <td>moip</td>
                <td class="t-status t-draft">aguardando pagamento</td>
                <td><a href="/accont/requests/1" class="btn btn-blue">detalhe</a></td>
            </tr>

            <tr>
                <td>1</td>
                <td>27/09/2013</td>
                <td>R$25,00</td>
                <td>moip</td>
                <td class="t-status t-scheduled">aguardando envio</td>
                <td><a href="/accont/requests/1" class="btn btn-blue">detalhe</a></td>
            </tr>
            <tr>
                <td>1</td>
                <td>27/09/2013</td>
                <td>R$25,00</td>
                <td>moip</td>
                <td class="t-status t-scheduled">aguardando chegada</td>
                <td><a href="/accont/requests/1" class="btn btn-blue">detalhe</a></td>
            </tr>
            <tr>
                <td>1</td>
                <td>27/09/2013</td>
                <td>R$25,00</td>
                <td>moip</td>
                <td class="t-status t-active">concluído</td>
                <td><a href="/accont/requests/1" class="btn btn-blue">detalhe</a></td>
            </tr>
            <tr>
                <td>1</td>
                <td>27/09/2013</td>
                <td>R$25,00</td>
                <td>moip</td>
                <td class="t-status">devolvido</td>
                <td><a href="/accont/requests/1" class="btn btn-blue">detalhe</a></td>
            </tr>
            <tr>
                <td>1</td>
                <td>27/09/2013</td>
                <td>R$25,00</td>
                <td>moip</td>
                <td class="t-status t-inactive">cancelado</td>
                <td><a href="/accont/requests/1" class="btn btn-blue">detalhe</a></td>
            </tr>
            </tbody>
        </table>
        <!-- END TABLE -->
    </section>
    <div class="clear-both"></div>
@endsection
