@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Todos os produtos cadastrados na loja</h1>
        </header>
        <form class="form-modern searh_store" action="javascript:void(0)">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <label>
                <input type="search" class="jq-input-search" name="product_name" placeholder="Pesquisar produto por nome">
            </label>
        </form>
        <table id="jq-search-table-result" class="table table-action">
            <thead>
            <tr>
                <th class="t-medium" style="width: 60px;">Imagem</th>
                <th>Nome</th>
                <th class="t-medium">Vendedor</th>
                <th class="t-small">Estoque</th>
                <th class="t-small">Visível</th>
                <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
            </tr>
            </thead>

            <tbody>
            @for ($i = 0; $i < 5; $i++)
                <tr>
                    <td><img src="{{ url('image/img-exemple.jpg') }}" alt="[]" title=""></td>
                    <td>Produto X</td>
                    <td>nome do vendedor<br> <a href="/juca" style="color: #B71C1C">loja</a></td>
                    <td class="txt-center">5</td>
                    <td class="t-draft txt-center">não</td>
                    <td class="txt-center">
                        <a href="javascript:void(0)" class="t-btn t-popmartin jq-info-product">detalhes</a>
                    </td>
                </tr>
            @endfor
            </tbody>
        </table>
    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_product_info')
@endsection
