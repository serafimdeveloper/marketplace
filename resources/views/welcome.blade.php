@extends('layouts.app')

@section('content')
    <section class="content" style="padding: 0 10px;">
        <header class="pop-title">
            <h1><span>Destaque</span></h1>
        </header>
        <div class="pop-home-prd owl-carousel">
        @for ($i = 0; $i < 5; $i++)
            <article class="modal-product">
                <ul>
                    <li><a href="javascript:void(0)"><i class="fa fa-heart"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa-facebook-official"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa-shopping-bag"></i></a></li>
                </ul>
                <figure>
                    <img src="{{ url('image/img-exemple.jpg') }}" alt="[]" title="">
                    <figcaption>R$ 24,90</figcaption>
                    <span class="frete"></span>
                    <span class="descont"></span>
                </figure>
                <header>
                    <h2><a href="/loja/produto/nome">Produto X customizado...</a></h2>
                    <p class="tagline"><a href="/loja/nome">Loja</a></p>
                </header>
            </article>
        @endfor
        </div>
        <div class="clear-both"></div>
    </section>
    <section class="content" style="padding: 0 10px;">
        <header class="pop-title">
            <h1><span>Novidades</span></h1>
        </header>
        <div class="pop-home-prd owl-carousel owl-theme owl-loaded">
            @for ($i = 0; $i < 5; $i++)
                <article class="modal-product">
                    <ul>
                        <li><a href="javascript:void(0)"><i class="fa fa-heart"></i></a></li>
                        <li><a href="javascript:void(0)"><i class="fa fa-facebook-official"></i></a></li>
                        <li><a href="javascript:void(0)"><i class="fa fa-shopping-bag"></i></a></li>
                    </ul>
                    <figure>
                        <img src="{{ url('image/img-exemple.jpg') }}" alt="[]" title="">
                        <figcaption>R$ 24,90</figcaption>
                        <span class="frete"></span>
                        <span class="descont"></span>
                    </figure>
                    <header>
                        <h2><a href="/loja/produto/nome">Produto X customizado...</a></h2>
                        <p class="tagline"><a href="/loja/nome">Loja</a></p>
                    </header>
                </article>
            @endfor
        </div>
        <div class="clear-both"></div>
    </section>
@endsection