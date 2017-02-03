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
                <figure style="border-bottom: 1px solid #e0e0e0;margin-bottom: 10px;">
                    <img id="img-product" src="{{ url('imagem/produto/camisa2.jpg') }}" alt="[]" title="">
                </figure>
                <ul class="pop-product-galery">
                    <li><img src="{{ url('imagem/produto/camisa.jpg') }}"></li>
                    <li><img src="{{ url('/imagem/produto/camisa2.jpg') }}"></li>
                    <li><img src="{{ url('/imagem/produto/camisa3.jpg') }}"></li>
                    <li><img src="{{ url('/imagem/produto/camisa4.jpg') }}"></li>
                </ul>
            </div>
            <article class="colbox-2">
                <header class="pop-title">
                    <h1>Nome do produto apresentado</h1>
                </header>
                <div class="padding05">
                    <a href="" class="btn btn-small btn-facebook"><i class="fa fa-facebook"></i> compartilhar</a>
                    <a href="" class="btn btn-small btn-facebook"><i class="fa fa-facebook"></i> recomendar</a>
                </div>
                <section>
                    <div class="colbox" style="margin: 30px 0;">
                        <div class="colbox-2 txt-center">
                            <span class="price">de R$ 29,90</span>
                            <p class="price-descont">R$14,90</p>
                            <span class="frete frete-gratis">FRETE GRÁTIS</span>
                            <span class="frete frete-pac">PAC</span>
                        </div>
                        <div class="colbox-2 txt-center">
                            <div class="btn-purshace">
                                <a class="btn btn-popmartin" href="/carrinho" title="">COMPRAR</a>
                                <span>30 peça(s) disponível(veis)Prazo de 2 dias para envio</span>
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
                                    Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica
                                    e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor
                                    desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro
                                    de modelos de tipos. Lorem Ipsum sobreviveu
                                </div>
                                <div class="wt-content">
                                    Lorem Ipsum 2 é simplesmente uma simulação de texto da indústria tipográfica
                                    e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor
                                    desconhecido pegou uma bandeja
                                </div>
                                <div class="wt-content">
                                    Lorem Ipsum 2 é simplesmente uma simulação de texto da indústria tipográfica
                                    e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor
                                    desconhecido pegou uma bandeja
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pop-product-salesman">
                        <div class="colbox">
                            <div class="colbox-2">
                                <p>Nome da Loja</p>
                            </div>
                            <div class="colbox-2">
                                <a id="messageToSalesman" class="btn btn-popmartin-trans"><i class="fa fa-comments-o"></i> contatar o vendedor</a>
                            </div>
                        </div>
                        <div class="clear-both"></div>
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
@endsection