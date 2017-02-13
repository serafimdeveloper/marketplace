@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Minhas mensagens</h1>
        </header>

        @if(!$messages)
            <p class="trigger notice fontem-14">Você não possui nenhuma mensagem</p>
        @else

        <!-- TABLE -->
            <table id="pop-messages" class="table table-action">
                <thead>
                <tr>
                    <th class="t-small"></th>
                    <th class="t-medium">De</th>
                    <th>Mensagem</th>
                    <th class="t-medium">Data</th>
                </tr>
                </thead>

                <tbody>
                @foreach($messages as $msg)
                    <tr {!! $msg->status == "received" ? 'class="t-unread"' : '' !!}>
                        <td>
                            <div class="form-modern">
                                <div class="checkbox-container">
                                    <div class="checkboxies">
                                        <label class="checkbox" style="border: none;padding: 0;">
                                            <span><span class="fa fa-square-o"></span></span>
                                            {!! Form::checkbox('msg', $msg->id, null, ['class' => 'select_msg']) !!}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $msg->sender->name }} {{ $msg->sender->last_name }}</td>
                        <td><a href="/accont/messages/{{ $msg->id }}">{{ substr($msg->content, 0, 60) }}...</a></td>
                        <td>{{ $msg->created_at->format("d/m/Y H:i:s") }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="fl-right">{!! $messages->render() !!}</div>
            <div class="clear-both"></div>
            <br>
            <a href="javascript:void(0)" id="pop-remove-msg" class="btn btn-small btn-gray cursor-nodrop">remover</a>
        @endif
    </section>
    <div class="clear-both"></div>
@endsection
