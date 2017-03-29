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

    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_product_info')
@endsection
