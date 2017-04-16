@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Banners
                <a href="javascript:void(0)" class="btn btn-smallextreme btn-popmartin fl-right jq-new-banner"> cadastrar novo banner</a>
            </h1>
        </header>

        <table class="table table-action">
            <thead>
            <tr>
                <th class="t-small">Imagem</th>
                <th class="t-small">Nome</th>
                <th class="t-medium">Descrição</th>
                <th class="t-medium">url</th>
                <th class="t-small">Início</th>
                <th class="t-small">Fim</th>
                <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
            </tr>
            </thead>
            <tbody>
            @for ($i = 0; $i < 5; $i++)
                <tr id="category_01">
                    <td><img src="s"></td>
                    <td>Loja do Juca</td>
                    <td>Uma loja de eletrodomésticos</td>
                    <td>/loja-do-juca</td>
                    <td>28/02/2017 às 12:00:00</td>
                    <td>28/03/2017 às 12:00:00</td>
                    <td class="txt-center">
                        <a href="javascript:void(0)" class="t-btn t-edit jq-new-banner" data-banner="1">editar</a>
                        <a href="javascript:void(0)" class="t-btn t-remove">remover</a>
                    </td>
                </tr>
            @endfor
            </tbody>
        </table>
    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_banner')
@endsection
