@extends('layouts.app')
@section('meta_facebook')
    <meta property="og:locale" content="pt_BR">
    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:title" content="{{ $product->name }}">
    <meta property="og:site_name" content="Pop Martin">
    <meta property="og:description" content="{{ strip_tags(substr($product->details, 0, 220)) }}">
    <meta property="og:image" content="{!! url('imagem/produto/'. $product->galeries->first()->image . '?w=500&h=500&fit=crop') !!}">
    <meta property="og:image:type" content="image/{{ image_type($product->galeries->first()->image) }}">

    <meta property="article:author" content="{{$product->store->name}}">
    <meta property="article:section" content="{{ strip_tags(substr($product->details, 0, 220)) }}">
    <meta property="article:published_time" content="{{ $product->created_at }}">
    <meta property="fb:app_id" content="1645780162393141">
@endsection
@section('content')
    <div class="content">
        {{--<ul class="segment-menu">--}}
        {{--<li><a href="">Home</a></li>--}}
        {{--<li><a href=""></a></li>--}}
        {{--</ul>--}}
    </div>
    <section class="content pop-product">
        <div class="colbox">
            <div class="colbox-2">
                <div class="coltable">
                    <div class="coltable-2">
                        <ul class="pop-product-galery">
                            @foreach($product->galeries as $galery)
                                <li><img src="{{ url('/imagem/produto/'.$galery->image.'?w=100&h=100&fit=crop') }}"></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="coltable-10">
                        <figure style="border-bottom: 1px solid #e0e0e0;margin-bottom: 10px;">
                            <img id="img-product" src="{{ url('imagem/produto/'.$product->galeries->first()->image.'?w=500&h=500&fit=crop') }}" alt="[]"
                                 title="">
                        </figure>
                    </div>
                </div>
                <div class="clear-both"></div>
                <div class="pop-product-salesman">
                        <div class="fl-left">
                            <p>{{$product->store->name}}</p>
                        </div>
                        <div class="fl-right">
                            <a class="btn btn-popmartin-trans {{ Auth::check() ? 'jq-new-message' : 'jq-auth' }}" data-message="para contatar o vendedor!">
                                <i class="fa fa-comments-o"></i> contatar o vendedor
                            </a>
                        </div>
                    <div class="clear-both"></div>
                </div>
            </div>
            <article class="colbox-2">
                <header class="pop-title">
                    <h1>{{$product->name}}</h1>
                </header>
                <div class="padding05">
                    <div class="fb-like" data-href="{{route('pages.product',
                    ['store'=>$product->store->slug,'category'=> $product->category->slug, 'product' => $product->slug])}}"
                         data-layout="button_count" data-action="like" data-size="large" data-show-faces="false" data-share="true"></div>
                </div>
                <section>
                    <div class="colbox" style="margin: 30px 0;">
                        <div class="colbox-2 txt-center">
                            @if(isset($product->price_out_discount))
                                <span class="price">de {{ real($product->price) }}</span>
                            @endif
                            <p class="price-descont">{{real(isset($product->price_out_discount)? $product->price_out_discount : $product->price)}}</p>
                            @if($product->free_shipping)
                                <span class="frete frete-gratis">FRETE GRÁTIS</span>
                            @else
                                <span class="frete frete-pac">PAC</span>
                                <span class="frete frete-pac" style="color:#fff">SEDEX</span>
                            @endif
                        </div>
                        <div class="colbox-2 txt-center">
                            <div class="btn-purshace">
                                <a class="btn btn-popmartin" href="{{route('pages.cart.add_product',['id'=>$product->id])}}" title="">COMPRAR</a>
                                <br>
                                <br>
                                <span>{{$product->quantity}} peça(s) disponível(veis)Prazo de {{$product->deadline}} dias para envio</span>
                            </div>
                            <br>
                            <br>
                            <div class="pop-rate">
                                <p>Avaliação do vendedor</p>
                                <div>
                                    Qualidade dos produtos:
                                    <div class="rating" data-rate-value="{{isset($notes->medium_product) ? $notes->medium_product : 0}}"></div>
                                </div>
                                <div>
                                    Atendimento:
                                    <div class="rating" data-rate-value="{{isset($notes->medium_attendance) ? $notes->medium_attendance : 0}}"></div>
                                </div>
                                <div>
                                    Vendas:
                                    <div style="color: #B71C1C">{{$count}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clear-both"></div>
                    <div class="pop-product-info">
                        <div class="wt">
                            <div class="wt-header">
                                <span class="wt-selected">DETALHES</span>
                                <span>POLÍTICAS DA LOJA</span>
                                <span>POLÍTICAS DE FRETE</span>
                            </div>
                            <div class="wt-container">
                                <div class="wt-content wt-selected wt-visible">
                                   {!! $product->details !!}
                                </div>
                                <div class="wt-content">
                                    {!! $product->store->exchange_policy !!}
                                </div>
                                <div class="wt-content">
                                    {!! $product->store->freight_policy !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </article>
        </div>
        <div class="clear-both"></div>
    </section>
    <div class="bs-dialog radius-small" title="Enviar mensagem para DESTINATÀRIO">
        <div class="bs-dialog-content">
            <form class="form-modern pop-form" action="" method="POST">
                <label>
                    <textarea name="message" rows="5" placeholder="Redija aqui sua mensagem"></textarea>
                </label>
                <div class="txt-center">
                    <button type="submit" class="btn btn-popmartin">Enviar</button>
                </div>
            </form>
        </div>
    </div>
    @include('layouts.parties.alert_message')
@endsection
@section('script')
    <script src="{{ asset('frontend/lib/rater/rater.min.js') }}"></script>
    <script>
        var rateOptions = {
            max_value: 5,
            step_size: 0.5,
            cursor: 'pointer',
            readonly: true
        }
        $(".rating").rate(rateOptions);
    </script>
@endsection
