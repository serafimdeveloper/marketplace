@extends('layouts.app')

@section('content')
    <br>
    <section class="content pop-carousel-home">
        <header class="pop-title">
            <h1>Destaque</h1>
        </header>
        <div class="pop-home-prd owl-carousel">
        @forelse ($features as $product)
            <article class="modal-product">
                <ul>
                    <li><a href="javascript:void(0)"><i class="fa fa-heart"></i></a></li>
                    <li><a href="javascript:void(0)"><i class="fa fa-facebook-official"></i></a></li>
                    <li><a href="javascript:void(0)" data-product="{{$product->id}}" class="add-cart"><i class="fa fa-cart-plus"></i></a></li>
                </ul>
                <figure>
                    <img src="{{ url('imagem/produto/'.$product->galeries->first()->image.'?w=250&h=250&fit=crop') }}" alt="[]" title="">
                    <figcaption><a href="{{route('pages.product',[$product->store->slug, $product->category->slug, $product->slug])}}">R${{number_format($product->price,2,',','.')}}</a></figcaption>
                    <span class="modal-product-frete"></span>
                    <span class="modal-product-descont"></span>
                </figure>
                <header>
                    <h2><a href="{{route('pages.product',[$product->store->slug, $product->category->slug, $product->slug])}}">{{$product->name}}</a></h2>
                    <p class="tagline"><a href="/juca">{{$product->store->name}}</a></p>
                </header>
            </article>
        @empty
            @for($i=0;$i<10;$i++)
                    <article class="modal-product">
                        <ul>
                            <li><a href="javascript:void(0)"><i class="fa fa-heart"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="fa fa-facebook-official"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="fa fa-cart-plus"></i></a></li>
                        </ul>
                        <figure>
                            <img src="{{ url('imagem/popmartin/img-exemple.jpg?w=250&h=250&fit=crop') }}" alt="[]" title="">
                            <figcaption><a href="#">R$ 0,00</a></figcaption>
                            <span class="modal-product-frete"></span>
                            <span class="modal-product-descont"></span>
                        </figure>
                        <header>
                            <h2><a href="#">Nome do Produto</a></h2>
                            <p class="tagline"><a href="#">Nome da Loja</a></p>
                        </header>
                    </article>
            @endfor
        @endforelse
        </div>
        <div class="clear-both"></div>
    </section>
    <section class="content pop-carousel-home">
        <header class="pop-title">
            <h1>Novidades</h1>
        </header>
        <div class="pop-home-prd owl-carousel">
            @forelse ($news as $product)
                <article class="modal-product">
                    <ul>
                        <li><a href="javascript:void(0)"><i class="fa fa-heart"></i></a></li>
                        <li><a href="javascript:void(0)"><i class="fa fa-facebook-official"></i></a></li>
                        <li><a href="javascript:void(0)" data-product="{{$product->id}}" class="add-cart"><i class="fa fa-cart-plus"></i></a></li>
                    </ul>
                    <figure>
                        <img src="{{ url('imagem/produto/'.$product->galeries->first()->image.'?w=250&h=250&fit=crop') }}" alt="[]" title="">
                        <figcaption><a href="{{route('pages.product',[$product->store->slug, $product->category->slug, $product->slug])}}">R${{number_format($product->price,2,',','.')}}</a></figcaption>
                        <span class="modal-product-frete"></span>
                        <span class="modal-product-descont"></span>
                    </figure>
                    <header>
                        <h2><a href="{{route('pages.product',[$product->store->slug, $product->category->slug, $product->slug])}}">{{$product->name}}</a></h2>
                        <p class="tagline"><a href="/juca">{{$product->store->name}}</a></p>
                    </header>
                </article>
            @empty
                @for($i=0;$i<10;$i++)
                    <article class="modal-product">
                        <ul>
                            <li><a href="javascript:void(0)"><i class="fa fa-heart"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="fa fa-facebook-official"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="fa fa-cart-plus"></i></a></li>
                        </ul>
                        <figure>
                            <img src="{{ url('imagem/popmartin/img-exemple.jpg?w=250&h=250&fit=crop') }}" alt="[]" title="">
                            <figcaption><a href="#">R$ 0,00</a></figcaption>
                            <span class="modal-product-frete"></span>
                            <span class="modal-product-descont"></span>
                        </figure>
                        <header>
                            <h2><a href="#">Nome do Produto</a></h2>
                            <p class="tagline"><a href="#">Nome da Loja</a></p>
                        </header>
                    </article>
                @endfor
            @endforelse
        </div>
        <div class="clear-both"></div>
    </section>
@endsection