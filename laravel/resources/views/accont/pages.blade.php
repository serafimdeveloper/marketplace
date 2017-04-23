@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Minhas páginas</h1>
        </header>
        <table id="jq-search-table-result" class="table table-action">
            <thead>
            <tr>
                <th>Title</th>
                <th class="t-medium txt-center"><i class="fa fa-gears"></i></th>

            </tr>
            </thead>

            <tbody>
            @foreach($pages as $page)
                <tr>
                    <td>{{ $page->title }}</td>
                    <td class="txt-center">
                        <a href="{{ route('accont.report.page.show', ['id' => $page->id]) }}" class="t-btn t-popmartin" data-page="1">detalhes</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
    <div class="clear-both"></div>
@endsection
