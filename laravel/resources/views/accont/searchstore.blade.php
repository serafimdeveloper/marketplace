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
@section('scripts_int')
    <script>
        $(document).on('click', '.pagination a', function (event) {
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var data = 'name=' + $(".jq-input-search").val();
            getData(page, data);
        });
    </script>
@endsection