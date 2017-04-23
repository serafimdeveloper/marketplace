@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>{{ $pages->title }}</h1>
        </header>
        @if(isset($erros))
            @foreach($erros->all() as $error)
                <div class="trigger error">
                    <p>{{ $error }}</p>
                </div>
            @endforeach

        @endif
        {{ Form::model($pages, ['route' => ['accont.report.page.update', $pages->id], 'class' => 'form form-modern pop-form']) }}
            <label>
                {{ Form::text('title', null, ['placeholder' => 'Título da página']) }}
            </label>
            <label>
                {{ Form::textarea('content', null, ['placeholder' => 'conteúdo da página']) }}
            </label>
            <div class="txt-center">
                <button type="submit" class="btn btn btn-popmartin">Atualizar</button>
            </div>
        {{ Form::close() }}
    </section>
    <div class="clear-both"></div>
@section('scripts_int')
    <script>
        tinymce.init({
            selector:'textarea',
            language: 'pt_BR',
            language_url: '{{ url('frontend/lib/tinymce/langs/pt_BR.js') }}',
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
            ],
            toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
            image_advtab: true,
            templates: [
                { title: 'Test template 1', content: 'Test 1' },
                { title: 'Test template 2', content: 'Test 2' }
            ],
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i'
            ]
        });
    </script>
@endsection
@endsection
