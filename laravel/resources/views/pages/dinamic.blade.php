@extends('layouts.app')

@section('content')
    <section class="content">
        @if(!$page)
            <div class="trigger warning">
                <h1>Erro 404</h1>

                <h2>Página não encontrada</h2>
            </div>
        @else
            <header class="pop-title">
                <h1>{{ $page->title }}</h1>
            </header>
            <article>
                {!!  $page->content !!}
            </article>
        @endif()
    </section>
@endsection