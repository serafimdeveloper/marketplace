@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Meus pedidos</h1>
        </header>

        <!-- TABLE -->
        <table class="table table-action">

            <thead>
            <tr>
                <th class="t-small">Pedidos</th>
                <th class="t-medium">Data</th>
                <th class="t-medium">Valor</th>
                <th class="t-medium">Loja</th>
                <th class="t-medium">Status</th>
                <th class="t-small"></th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>1</td>
                <td>27/09/2013</td>
                <td>R$25,00</td>
                <td>Pop Martin</td>
                <td class="t-status t-draft">aguardando pagamento</td>
                <td class="txt-center"><a href="/accont/requests/1" class="t-popmartin">detalhes</a></td>
            </tr>

            <tr>
                <td>1</td>
                <td>27/09/2013</td>
                <td>R$25,00</td>
                <td>Pop Martin</td>
                <td class="t-status t-scheduled">aguardando envio</td>
                <td class="txt-center"><a href="/accont/requests/1" class="t-popmartin">detalhes</a></td>
            </tr>
            <tr>
                <td>1</td>
                <td>27/09/2013</td>
                <td>R$25,00</td>
                <td>Pop Martin</td>
                <td class="t-status t-scheduled">aguardando chegada</td>
                <td class="txt-center"><a href="/accont/requests/1" class="t-popmartin">detalhes</a></td>
            </tr>
            <tr>
                <td>1</td>
                <td>27/09/2013</td>
                <td>R$25,00</td>
                <td>Pop Martin</td>
                <td class="t-status t-active">concluído</td>
                <td class="txt-center"><a href="/accont/requests/1" class="t-popmartin">detalhes</a></td>
            </tr>
            <tr>
                <td>1</td>
                <td>27/09/2013</td>
                <td>R$25,00</td>
                <td>Pop Martin</td>
                <td class="t-status">devolvido</td>
                <td class="txt-center"><a href="/accont/requests/1" class="t-popmartin">detalhes</a></td>
            </tr>
            <tr>
                <td>1</td>
                <td>27/09/2013</td>
                <td>R$25,00</td>
                <td>Pop Martin</td>
                <td class="t-status t-inactive">cancelado</td>
                <td class="txt-center"><a href="/accont/requests/1" class="t-popmartin">detalhes</a></td>
            </tr>
            </tbody>
        </table>
        <!-- END TABLE -->
    </section>
    <div class="clear-both"></div>
@endsection
