@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Minhas mensagens</h1>
        </header>
        <br>
        <div>
            <a href="{{route('accont.messages.box',['type'=> $type, 'box' => 'received'])}}"
               class="btn btn-small {{ $box === 'received' ? 'btn-popmartin-trans' : 'btn-popmartin'}}">
                {!! ($box === 'received' ? '<i class="fa fa-angle-down"></i>' : '') !!}
                Caixa de entrada

            </a>
            <a href="{{route('accont.messages.box',['type'=> $type, 'box' => 'send'])}}"
               class="btn btn-small {{ $box === 'send' ? 'btn-popmartin-trans' : 'btn-popmartin'}}">
                {!! ($box === 'send' ? '<i class="fa fa-angle-down"></i>' : '') !!}
                Caixa de saída</a>
        </div>

        @if(!$messages)
            <p class="trigger notice fontem-14">Nenhuma
                mensagem {{ ($box === 'received' ? 'recebida' : 'enviada') }}</p>
        @else


        <!-- TABLE -->
            <table id="pop-messages" class="table table-action">
                <thead>
                <tr>
                    <th class="t-small"></th>
                    <th class="t-medium">{{ ($box === 'received' ? 'De' : 'Para') }}</th>
                    <th>Mensagem</th>
                    <th class="t-medium">Data</th>
                </tr>
                </thead>

                <tbody>
                @foreach($messages as $msg)
                    @if($box == 'received')
                        <tr {!! $msg->first()->status == "received" ? 'class="t-unread"' : '' !!}>
                    @endif
                            <td>
                                <div class="form-modern">
                                    <div class="checkbox-container">
                                        <div class="checkboxies">
                                            <label class="checkbox" style="border: none;padding: 0;">
                                                <span><span class="fa fa-square-o"></span></span>
                                                {!! Form::checkbox('msg', ($box === 'received') ? $msg->first()->id : $msg->id, null, ['class' => 'select_msg']) !!}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ ($box === 'received') ?  $msg->first()->sender->name : $msg->recipient->name}}</td>
                            <td>
                                <a href="{{ route('accont.message.info', ['type' => $box, 'id' => ($box === 'received') ? $msg->first()->id : $msg->id]) }}">{!!  substr(($box === 'received') ? $msg->first()->content : $msg->content, 0, 60) !!}
                                    ...</a></td>
                            <td>{{ ($box === 'received') ? $msg->first()->created_at->format('d/m/Y H:i:s') : $msg->created_at->format("d/m/Y H:i:s") }}</td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
            <div class="fl-right">{!! $messages->render() !!}</div>
            <div class="clear-both"></div>
            <br>
            <a href="javascript:void(0)" id="pop-remove-msg" data-token="{{csrf_token()}}"
               class="btn btn-small btn-gray cursor-nodrop">remover</a>
        @endif
    </section>
    <div class="clear-both"></div>
@endsection
