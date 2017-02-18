@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Procure uma loja</h1>
        </header>
        <form class="form-modern pop-form searh_store" action="javascript:void(0)">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <label>
                <input type="search" name="search_store" class="jq-input-search" placeholder="Pesquisar Loja">
            </label>
        </form>
        <div id="result">
            @include('accont.presearchstore')
        </div>
    </section>
    <div class="clear-both"></div>
@endsection
