@extends('layouts.app')

@section('content')
    <br>
    <section class="content pop-carousel-home">
        <header class="pop-title">
            <h1>Destaque</h1>
        </header>
        <div class="pop-home-prd owl-carousel">
        @for ($i = 0; $i < 20; $i++)
            <article class="modal-product">
                <ul>
                    <li><a href="javascript:void(0)"><i class="fa fa-heart"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa-facebook-official"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa-cart-plus"></i></a></li>
                </ul>
                <figure>
                    <img src="{{ url('imagem/produto/camisa.jpg') }}" alt="[]" title="">
                    <figcaption><a href="/juca/produto/nome-produto">R$ 24,90</a></figcaption>
                    <span class="modal-product-frete"></span>
                    <span class="modal-product-descont"></span>
                </figure>
                <header>
                    <h2><a href="/juca/produto/nome-produto">Produto X customizado...</a></h2>
                    <p class="tagline"><a href="/juca">Loja</a></p>
                </header>
            </article>
        @endfor
        </div>
        <div class="clear-both"></div>
    </section>
    <section class="content pop-carousel-home">
        <header class="pop-title">
            <h1>Novidades</h1>
        </header>
        <div class="pop-home-prd owl-carousel">
            @for ($i = 0; $i < 20; $i++)
                <article class="modal-product">
                    <ul>
                        <li><a href="javascript:void(0)"><i class="fa fa-heart"></i></a></li>
                        <li><a href="javascript:void(0)"><i class="fa fa-facebook-official"></i></a></li>
                        <li><a href="javascript:void(0)"><i class="fa fa-cart-plus"></i></a></li>
                    </ul>
                    <figure>
                        <img src="{{ url('imagem/produto/camisa.jpg') }}" alt="[]" title="">
                        <figcaption>R$ 24,90</figcaption>
                        <span class="modal-product-frete"></span>
                        <span class="modal-product-descont"></span>
                    </figure>
                    <header>
                        <h2><a href="/juca/produto/nome-produto">Produto X customizado...</a></h2>
                        <p class="tagline"><a href="/juca">Loja</a></p>
                    </header>
                </article>
            @endfor
        </div>
        <div class="clear-both"></div>
    </section>
@endsection