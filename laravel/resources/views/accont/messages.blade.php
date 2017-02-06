@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Minhas mensagens</h1>
        </header>
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
            @for ($i = 1; $i < 4; $i++)
                <tr class="t-unread">
                    <td><label><input type="checkbox" class="select_msg" name="msg" value="{{$i}}"></label></td>
                    <td>Luíz Fernando</td>
                    <td><a href="/accont/messages/1">Alguma informação sobre esta mensagem...</a></td>
                    <td>hoje ás 10:25:14</td>
                    <td class="t-active"></td>
                </tr>
            @endfor
            <tr>
                <td><label><input type="checkbox" class="select_msg" name="msg" value="13"></label></td>
                <td>Luíz Fernando</td>
                <td><a href="/accont/messages/1">Alguma informação sobre esta mensagem...</a></td>
                <td>hoje ás 10:25:14</td>
                <td class="t-active">respondida</td>
            </tr>
            </tbody>
        </table>
        <a href="javascript:void(0)" id="pop-remove-msg" class="btn btn-small btn-popmartin">remover mensagens selecionada</a>
    </section>
    <div class="clear-both"></div>
@endsection
