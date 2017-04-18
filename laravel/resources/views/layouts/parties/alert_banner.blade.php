<div class="alertbox" id="alert-banner">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <h2 class="alertbox-title c-pop fontw-500">Cadastrar banner</h2>
            @if(isset($result))
                {!! Form::model($result,['class' => 'form-modern pop-form form-banner', 'route' =>['accont.banner.update',$result->id], 'method' => 'POST']) !!}
            @else
                {!! Form::open(['class' => 'form-modern pop-form form-banner', 'route' => ['accont.banner.store'], 'method' => 'POST']) !!}
            @endif
                <div class="colbox">
                    <div class="colbox-2">
                        <label>
                           <span>Loja</span>
                           {!! Form::select('store_id',$stores,null,['placeholder' => 'Selecione uma loja']) !!}
                        </label>
                    </div>
                    <div class="colbox-2">
                        <label>
                            <span>Título do banner</span>
                            {!! Form::text('title', null, ['placehoder' => 'Título do banner']) !!}
                        </label>

                    </div>
                </div>
                <div class="colbox">
                    <div class="colbox-full">
                        <label>
                            <span>Url da loja</span>
                            {!!  Form::text('url', null, ['placehoder' => 'url da loja']) !!}
                        </label>
                    </div>
                    <div class="colbox-full">
                        <label>
                            <span>Description</span>
                            {!!  Form::text('description', null, ['placehoder' => 'Descrição do banner']) !!}
                        </label>
                    </div>
                </div>
                <div class="colbox">
                    <div class="colbox-2">
                        <label>
                            <span>Início</span>
                            {!! Form::input('datetime-local', 'date_start',  null, ['class' => 'datetimepicker_datetime', 'placehoder' => 'data e hora inicial']) !!}
                        </label>
                    </div>
                    <div class="colbox-2">
                        <label>
                            <span>Fim</span>
                            {!! Form::input('datetime-local', 'date_end',  null, ['class' => 'datetimepicker_datetime', 'placehoder' => 'data e hora final']) !!}
                        </label>
                    </div>
                </div>
                <div class="clear-both"></div>
                <div class="txt-center">
                    <button type="submit" class="btn btn-popmartin">cadastrar</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@section('css')
    <link href="/public/frontend/lib/datetimepicker/jquery.datetimepicker.min.css" rel="stylesheet">
@endsection
@section('scripts_int')
    <script src="/public/frontend/lib/datetimepicker/jquery.datetimepicker.full.min.js"></script>
    <script>
        $.datetimepicker.setLocale('pt-BR');
        $('.datetimepicker_datetime').datetimepicker();

    </script>
@endsection
