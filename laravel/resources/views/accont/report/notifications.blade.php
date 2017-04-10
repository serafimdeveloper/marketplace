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
            @foreach($ntfs as $ntf)
                <tr id="ntf{{ $ntf->id }}"{!! ( !$ntf->read ? ' class="t-unread"' : '') !!}>
                    <td>Alerta</td>
                    <td><a href="javascript:void(0)" class="jq-notification" data-id="{{ $ntf->id }}">Usuário {{ $ntf->message->sender->name }} enviou por mensagem, informações....</a></td>
                    <td>{{$ntf->created_at->diffForHumans()}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{--<a href="javascript:void(0)" id="pop-remove-msg" class="btn btn-small btn-popmartin">remover mensagens selecionada</a>--}}
        <div class="fl-right">{!! $ntfs->links() !!}</div>
        <div class="clear-both"></div>
    </section>
    <div class="clear-both"></div>
    <div id="notificationParties"></div>
    {{--@include('layouts.parties.alert_notification')--}}
@endsection
