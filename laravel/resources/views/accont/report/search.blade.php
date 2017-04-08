@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>{{$title}}</h1>
        </header>
        <form class="form-modern pop-form searh_store" action="javascript:void(0)">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <label>
                <input type="search" class="jq-input-search" name="user_name" placeholder="Pesquisar usuário por e-mail">
            </label>
        </form>
        <div id="result">
            @include('accont.report.presearch')
        </div>
    </section>
    <div class="clear-both"></div>
   <div id="resp_modal"></div>

@endsection
@section('scripts_int')
    <script>
        $(function(){
            $(document).on('click', '.pagination a', function (event) {
                $('li').removeClass('active');
                $(this).parent('li').addClass('active');
                var page = $(this).attr('href').split('page=')[1];
                var data = 'name=' + $(".jq-input-search").val();
                console.log(data, page);
                getData(page, data);
                event.preventDefault();
            });
        });
    </script>
@endsection

