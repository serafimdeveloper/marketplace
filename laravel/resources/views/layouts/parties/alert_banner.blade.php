<div class="alertbox" id="alert-banner">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <h2 class="alertbox-title c-pop fontw-500">{{isset($result) ? 'Editar Banner' : 'Cadastrar Banner'}}</h2>
            @if(isset($result))
                {!! Form::model($result,['class' => 'form-modern pop-form form-banner', 'route' =>['accont.report.banner.update',$result->id], 'method' => 'POST']) !!}
            @else
                {!! Form::open(['class' => 'form-modern pop-form form-banner', 'route' => ['accont.report.banner.store'], 'method' => 'POST']) !!}
            @endif

                <div class="colbox">
                    <div class="colbox-full">
                        <label>
                           <span>Loja</span>
                           {!! Form::select('store_id',$stores,null,['placeholder' => 'Selecione uma loja', 'required' => true]) !!}
                        </label>
                    </div>
                    <div class="colbox-full">
                        <label>
                            <span>Description</span>
                            {!!  Form::text('description', null, ['placehoder' => 'Descrição do banner', 'required' => 'true', 'maxlenght' => 30]) !!}
                            <span class="alert{{ $errors->has('description') ? '' : ' hidden' }}">{{ $errors->first('description') }}</span>
                        </label>
                    </div>
                </div>
                <div class="colbox">
                    <div class="colbox-2">
                        <label>
                            <span>Início</span>
                            {!! Form::input('datetime-local', 'date_start',  isset($result->date_start) ? $result->date_start->toAtomString() : null, ['class' => 'datetimepicker_datetime', 'placehoder' => 'data e hora inicial', 'required' => true]) !!}
                        </label>
                    </div>
                    <div class="colbox-2">
                        <label>
                            <span>Fim</span>
                            {!! Form::input('datetime-local', 'date_end',  isset($result->date_end) ? $result->date_end->toAtomString() : null, ['class' => 'datetimepicker_datetime', 'placehoder' => 'data e hora final', 'required' => true]) !!}
                        </label>
                    </div>
                </div>
                <div class="clear-both"></div>
                <div class="txt-center">
                    <button type="submit" class="btn btn-popmartin">{{isset($result) ? 'atualizar' : 'cadastrar'}}</button>
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
