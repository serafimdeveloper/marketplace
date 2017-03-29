@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Nome da página</h1>
        </header>
        <form class="form-modern pop-form" action="" method="POST">
            <label>
                {{ Form::text('name', null, ['placeholder' => 'nome da página']) }}
            </label>
            <label>
                {{ Form::text('title', null, ['placeholder' => 'Título da página']) }}
            </label>
            <label>
                {{ Form::textarea('content', null, ['placeholder' => 'conteúdo da página']) }}
            </label>
            <div class="txt-center">
                <button type="submit" class="btn btn btn-popmartin">Atualizar</button>
            </div>
        </form>
    </section>
    <div class="clear-both"></div>
@endsection
@section('script')
    <script src="/public/frontend/lib/tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector:'textarea',
            language: 'pt_BR',
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