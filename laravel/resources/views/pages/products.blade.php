@extends('layouts.app')

@section('content')
    <section class="content pop-store">
        <header class="pop-title">
            <h1>Buscando "{{$search}}"</h1>
        </header>
        <div class="colbox">
            @forelse($products as $product)
                <div class="colbox-5">
                    <article class="modal-product">
                        <ul>
                            @if(Auth::check())
                                <li><a href="javascript:void(0)" class="add-favorite" data-product="{{$product->id}}" data-message=" para adicionar ao seus favoritos!">
                                        <i class="fa fa-heart {{is_favorite($favorites, $product->store_id, $product->id) ? 'c-reddark': ''}}"></i>
                                    </a></li>
                            @else
                                <li><a href="javascript:void(0)" class="jq-auth"  data-message=" para adicionar ao seus favoritos!"><i class="fa fa-heart"></i></a></li>
                            @endif
                            <li><a href="javascript:void(0)"><i class="fa fa-facebook-official"></i></a></li>
                            <li><a href="javascript:void(0)" data-product="{{$product->id}}" class="add-cart"><i
                                            class="fa fa-cart-plus"></i></a></li>
                        </ul>
                        <figure>
                            <img src="{{ url('imagem/produto/'.$product->galeries->first()->image.'?w=250&h=250&fit=crop') }}" alt="[]" title="">
                            <figcaption><a href="{{route('pages.product',[$product->store->slug, $product->category->slug, $product->slug])}}">{{real(isset($product->price_out_discount)? $product->price_out_discount : $product->price)}}</a></figcaption>
                            @if($product->free_shipping)
                                <span class="modal-product-frete"><i class="fa fa-truck"></i> frete grátis</span>
                            @endif
                            @if($product->price_out_discount)
                                <div class="modal-discont">
                                    <span class="modal-product-descont-percent">{{ discont_percent($product->price, $product->price_out_discount) }}% OFF</span>
                                    <span class="modal-product-descont">{{isset($product->price_out_discount) ? real($product->price) : ''}}</span>
                                </div>
                            @endif
                        </figure>
                        <header>
                            <h2><a href="{{route('pages.product',[$product->store->slug, $product->category->slug, $product->slug])}}">{{limit_text($product->name,50)}}</a></h2>
                            <p class="tagline"><a href="{{route('pages.store',['store' => $product->store->slug])}}">{{$product->store->name}}</a></p>
                        </header>
                    </article>
                </div>
            @empty
                <h2>Nenhum produto encontrado</h2>
            @endforelse
        </div>
        <div class="clear-both"></div>
    </section>
@endsection