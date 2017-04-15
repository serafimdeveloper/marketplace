@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>{{$title}}</h1>
        </header>
        @if($type === 'products')
        <form class="form-modern pop-form form-search" action="javascript:void(0)">
            <div class="colbox">
                <div class="colbox-2">
                    <label>
                        <input type="search" class="jq-input-search" name="name" data-type="{{$type}}" placeholder="{{$placeholder}}">
                    </label>
                </div>
                <div class="colbox-2">
                    <div class="form-modern">
                      {!! Form::select('store_id',$stores,null,['placeholder' => 'Selecione uma loja', 'class'=>'jq-input-search']) !!}
                    </div>
                </div>
            </div>
        </form>

        @else
        <form class="form-modern pop-form form-search" action="javascript:void(0)">
            <label>
                <input type="search" class="jq-input-search" name="name" data-type="{{$type}}" placeholder="{{$placeholder}}">
            </label>
        </form>
        @endif


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

