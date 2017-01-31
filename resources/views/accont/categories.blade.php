@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Categorias cadastrada no sistema</h1>
        </header>
        <table class="table table-action">
            <thead>
            <tr>
                <th class="t-medium">Nome</th>
                <th class="t-medium">categoria PAI</th>
                <th class="t-medium">url</th>
                <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
            </tr>
            </thead>
            <tbody>
            @for ($i = 0; $i < 5; $i++)
                <tr id="category_01">
                    <td>Nome da categoria</td>
                    <td>nome categoria pai</td>
                    <td>nome-da-categoria</td>
                    <td class="txt-center">
                        <a href="javascript:void(0)" class="t-btn t-edit jq-info-user" data-category="">detalhes</a>
                        <a href="javascript:void(0)" class="t-btn t-remove">remover</a>
                    </td>
                </tr>
            @endfor
            </tbody>
        </table>
    </section>
    <div class="clear-both"></div>
@endsection
