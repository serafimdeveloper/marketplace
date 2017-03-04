@extends('layouts.app')

@section('content')
    <br>
    <section class="content pop-carousel-home">
        <header class="pop-title">
            <h1>Destaque</h1>
        </header>
        <div class="pop-home-prd owl-carousel">
        @foreach ($features as $product)
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
        @endforeach
        </div>
        <div class="clear-both"></div>
    </section>
    <section class="content pop-carousel-home">
        <header class="pop-title">
            <h1>Novidades</h1>
        </header>
        <div class="pop-home-prd owl-carousel">
            @foreach ($news as $product)
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
            @endforeach
        </div>
        <div class="clear-both"></div>
    </section>
@endsection