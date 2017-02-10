@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Minhas mensagens</h1>
        </header>

        @if(!$messages)
            <p class="trigger notice fontem-14">Você não possui menssagens</p>
    @else

        <!-- TABLE -->
        <table id="pop-messages" class="table table-action">
            <thead>
            <tr>
                <th class="t-small"></th>
                <th class="t-medium">De</th>
                <th>Mensagem</th>
                <th class="t-medium">Data</th>
                <th class="t-small"></th>
            </tr>
            </thead>

            <tbody>
            @foreach($messages as $msg)
                <tr class="t-unread">
                    <td><label><input type="checkbox" class="select_msg" name="msg" value="{{ $msg->id }}"></label></td>
                    <td>{{ $msg->sender->name }} {{ $msg->sender->last_name }}</td>
                    <td><a href="/accont/messages/{{ $msg->id }}">{{ substr($msg->content, 0, 60) }}...</a></td>
                    <td>{{ $msg->created_at->format("d/m/Y H:i:s") }}</td>
                    <td class="t-active"></td>
                </tr>
            @endforeach
            </tbody>
        </table>
            {!! $messages->render() !!}
        @endif
        <div class="clear-both"></div>
        <br>
        <a href="javascript:void(0)" id="pop-remove-msg" class="btn btn-small btn-popmartin">remover mensagens selecionada</a>
    </section>
    <div class="clear-both"></div>
@endsection
