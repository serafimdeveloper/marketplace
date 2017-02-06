<div class="alertbox" id="jq-new-banner">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <h2 class="alertbox-title c-pop fontw-500">Cadastrar banner</h2>
            <form class="form-modern pop-form" action="javascript:void(0)" method="POST">

                <div class="colbox">
                    <div class="colbox-2">
                        <label>
                            <span>Loja</span>
                            <select name="store">
                                <option selected disabled>selecionar loja</option>
                                <option value="">loja 1</option>
                                <option value="">loja 1</option>
                            </select>
                        </label>
                    </div>
                    <div class="colbox-2">
                        <label>
                            <span>Título do banner</span>
                            {{ Form::text('title', null, ['placehoder' => 'Título do banner']) }}
                        </label>

                    </div>
                </div>
                <div class="colbox">
                    <div class="colbox-full">
                        <label>
                            <span>Descrição</span>
                            {{ Form::text('url', null, ['placehoder' => 'url da loja']) }}
                        </label>
                    </div>
                    <div class="colbox-full">
                        <label>
                            <span>Url da loja</span>
                            {{ Form::text('description', null, ['placehoder' => 'Descrição do banner']) }}
                        </label>
                    </div>
                </div>
                <div class="colbox">
                    <div class="colbox-2">
                        <label>
                            <span>Início</span>
                            {{ Form::input('datetime-local', 'start',  null, ['class' => 'datetimepicker_datetime', 'placehoder' => 'data e hora inicial']) }}
                        </label>
                    </div>
                    <div class="colbox-2">
                        <label>
                            <span>Fim</span>
                            {{ Form::input('datetime-local', 'end',  null, ['class' => 'datetimepicker_datetime', 'placehoder' => 'data e hora final']) }}
                        </label>
                    </div>
                </div>
                <div class="clear-both"></div>
                <div class="txt-center">
                    <button type="submit" class="btn btn-popmartin">cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@section('css')
    <link href="/frontend/lib/datetimepicker/jquery.datetimepicker.min.css" rel="stylesheet">
@endsection
@section('script')
    <script src="/frontend/lib/datetimepicker/jquery.datetimepicker.full.min.js"></script>
    <script>
        $.datetimepicker.setLocale('pt-BR');
        $('.datetimepicker_datetime').datetimepicker();

    </script>
    @endsection
