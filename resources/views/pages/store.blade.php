@extends('layouts.app')

@section('content')
    <section class="content pop-store">
        <div class="coltable">
            <div class="coltable-3">
                <div class="pop-store-info">
                    <img src="{{ url('/imagem/loja/L1V1U1.gif') }}" alt="[]" title="">
                    <div>
                        <p>
                            <span class="fontem-14 fontw-800 c-pop">Nome da Loja</span><br>
                            <span>Volta Redonda, RJ</span>
                        </p>
                        <p></p>
                        <p>Cadastrado em: 27/11/2016<br>2 produtos</p>
                    </div>
                </div>
            </div>
            <div class="coltable-9 pop-store-products">
                <header class="pop-title">
                    <h1>Produtos - nome da loja</h1>
                </header>
                <div class="colbox">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="colbox-4">
                            <article class="modal-product">
                                <ul>
                                    <li><a href="javascript:void(0)"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-facebook-official"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-cart-plus"></i></a></li>
                                </ul>
                                <figure>
                                    <img src="{{ url('imagem/produto/camisa.jpg?w=350&h=350&fit=crop') }}" alt="[]" title="">
                                    <figcaption>R$ 24,90</figcaption>
                                    <span class="modal-product-frete"></span>
                                    <span class="modal-product-descont"></span>
                                </figure>
                                <header>
                                    <h2><a href="/juca/produto/nome-produto">Produto X customizado...</a></h2>
                                </header>
                            </article>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
        <div class="clear-both"></div>
    </section>
@endsection