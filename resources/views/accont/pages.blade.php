@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Minhas páginas
                <a href="/accont/page" class="btn btn-smallextreme btn-popmartin fl-right"> nova página</a>
            </h1>
        </header>
        <table id="jq-search-table-result" class="table table-action">
            <thead>
            <tr>
                <th class="t-medium">nome</th>
                <th>Title</th>
                <th class="t-medium txt-center"><i class="fa fa-gears"></i></th>

            </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Contato</td>
                    <td>Suporte Pop Martin</td>
                    <td class="txt-center">
                        <a href="/accont/page/1" class="t-btn t-popmartin" data-page="1">detalhes</a>
                    </td>
                </tr>
                <tr>
                    <td>Políticas de privacidade</td>
                    <td>Políticas de privacidade Pop Martin</td>
                    <td class="txt-center">
                        <a href="javascript:void(0)" class="t-btn t-popmartin jq-info-sales" data-page="2">detalhes</a>
                    </td>
                </tr>
                <tr>
                    <td>Como comprar</td>
                    <td>Siba como comprar no Pop Martin de forma simples, segura e rápida</td>
                    <td class="txt-center">
                        <a href="javascript:void(0)" class="t-btn t-popmartin jq-info-sales" data-page="3">detalhes</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
    <div class="clear-both"></div>
    <script src="//cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
@endsection
