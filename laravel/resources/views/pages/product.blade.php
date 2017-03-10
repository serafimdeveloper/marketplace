@extends('layouts.app')

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
                            <a class="btn btn-popmartin-trans {{ isset($auth) ? 'jq-new-message' : 'jq-auth' }}">
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
                    <a href="" class="btn btn-small btn-facebook"><i class="fa fa-facebook"></i> compartilhar</a>
                    <a href="" class="btn btn-small btn-facebook"><i class="fa fa-facebook"></i> curtir</a>
                </div>
                <section>
                    <div class="colbox" style="margin: 30px 0;">
                        <div class="colbox-2 txt-center">
                            <span class="price">de R${{number_format($product->price,2,',','.')}}</span>
                            <p class="price-descont">R${{number_format($product->price_out_discount,2,',','.')}}</p>
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
                                    Qualidade do produto:
                                    <div class="rating" data-rate-value=3></div>
                                </div>
                                <div>
                                    Atendimento:
                                    <div class="rating" data-rate-value="4"></div>
                                </div>
                                <div>
                                    Vendas:
                                    <div style="color: #B71C1C">652</div>
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
                                   {{$product->details}}
                                </div>
                                <div class="wt-content">
                                    {{$product->store->exchange_policy}}
                                </div>
                                <div class="wt-content">
                                    {{$product->store->freight_policy}}
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
    <script src="/public/frontend/lib/rater/rater.min.js"></script>
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
