@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Notificações do sistema</h1>
        </header>
        <!-- TABLE -->
        <table id="pop-messages" class="table table-action">
            <thead>
            <tr>
                <th class="t-medium">Notificação</th>
                <th>Mensagem</th>
                <th class="t-medium">Data</th>
            </tr>
            </thead>

            <tbody>
            @for ($i = 1; $i < 3; $i++)
                <tr class="t-unread">
                    <td>Alerta</td>
                    <td><a href="javascript:void(0)" class="jq-notification">Usuário Luís Fernando enviou por mensagem, informações....</a></td>
                    <td>hoje ás 10:25:14</td>
                </tr>
            @endfor
            <tr>
                <td>Erro</td>
                <td><a href="javascript:void(0)" class="jq-notification">Resumo da mensagem de erro</a></td>
                <td>hoje ás 10:25:14</td>
            </tr>
            <tr>
                <td>Alerta</td>
                <td><a href="javascript:void(0)" class="jq-notification">Usuário Luís Fernando enviou por mensagem, informações....</a></td>
                <td>hoje ás 10:25:14</td>
            </tr>
            </tbody>
        </table>
        <a href="javascript:void(0)" id="pop-remove-msg" class="btn btn-small btn-popmartin">remover mensagens selecionada</a>
    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_notification')
@endsection
