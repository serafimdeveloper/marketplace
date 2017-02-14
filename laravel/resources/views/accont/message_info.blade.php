@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1><i class="fa fa-comments-o"></i> Conversa
                com {{ $message->sender->name }} {{ $message->sender->last_name }}</h1>
        </header>
        @if(isset($message->request) && Request::segment(2) == 'messages')
            <div class="trigger notice jq-scrollposition">
                <a href="/accont/requests/{{ $message->request->id }}" class="c-white">
                    <i class="fa fa-newspaper-o"></i>
                    Conversa relacionada ao <b>pedido</b>: {{ $message->request->key }}
                    <span class="btn btn-smallextreme btn-popmartin vertical-middle">ver pedido</span>
                </a>
            </div>
        @elseif(isset($message->request))
            <div class="trigger notice jq-scrollposition">
                <a href="/accont/salesman/sale/{{ $message->request_id }}" class="c-white">
                    <i class="fa fa-newspaper-o"></i>
                    Conversa relacionada a <b>venda</b>: {{ $message->request->key }}
                    <span class="btn btn-smallextreme btn-popmartin vertical-middle"> ver venda</span>
                </a>
            </div>
        @elseif(isset($message->product))
            <div class="trigger notice jq-scrollposition">
                <a href="/juca/produto/{{ $message->product->slug }}" class="c-white" target="_blank">
                    <img class="dp-inblock vertical-middle"
                         src="{{ url('imagem/produto/' . $message->product->galeries[0]->image . '?w=42&h=42&filt=crop') }}"
                         alt="imagem" title="imagem">
                    Conversa relacionada ao produto <b>{{ $message->product->name }}</b>
                    <span class="btn btn-smallextreme btn-popmartin vertical-middle">ver produto</span>
                </a>
            </div>
        @endif()


        <table class="table table-action">
            <thead>
            <tr>
                <th class="t-medium"></th>
                <th>Mensagem</th>
            </tr>
            </thead>

            <tbody>
             @foreach($messages as $awnser)
                    <tr id="{{$awnser->id}}">
                        <td>{{ $awnser->sender->name }}<br><span>{{ $awnser->created_at->format('d/m/Y H:i:s') }}</span>
                        </td>
                        <td>{{ $awnser->content }}</td>
                    </tr>
             @endforeach
             {!! $messages->links() !!}
            </tbody>
        </table>
        <div>
            {!!Form::open(['route'=>['accont.message.answer', $message->id], 'method'=>'POST','class'=>'form-modern pop-form'])!!}
                <p class="c-pop fontw-600 box-marginzero">Responder</p>
                <label>
                    {!! Form::textarea('message', null, ['id' => 'comments-limit', 'class' => 'limiter-textarea', 'rows' => '4', 'maxlength' => 500]) !!}
                    <span class="limiter-result" for="comments-limit">limite de 500 caracteres</span>
                    <span class="alert{{ $errors->has('message') ? '' : ' hidden' }}">{{ $errors->first('message') }}</span>

                </label>
                <div class="txt-left">
                    <button type="submit" class="btn btn-popmartin">enviar</button>
                </div>
            {!! Form::close() !!}
        </div>

    </section>
    <div class="clear-both"></div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            var url_atual = window.location.href;
            var url = url_atual.split('/');
            var hash = parseInt(url[5]);
            console.log(typeof hash);
            if(typeof hash === 'number'){
                console.log('chegou');
                var position = $('#'+hash).offset();
                $("html, body").animate({scrollTop:position.top - 125}, 1200);
            }
        });
    </script>
@endsection