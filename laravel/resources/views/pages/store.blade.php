@extends('layouts.app')

@section('content')
    <section class="content pop-store">
        <div class="coltable">
            <div class="coltable-3">
                <div class="pop-store-info">
                    <img src="{{ url('/imagem/loja/'.$store->logo_file) }}" alt="{{$store->name}}" title="{{$store->name}}">
                    <div>
                        <p>
                            <span class="fontem-14 fontw-800 c-pop">{{$store->name}}</span><br>
                            <span>{{$store->adress->city.', '.$store->adress->state}}</span>
                        </p>
                        <p></p>
                        <p>Cadastrado em: {{$store->created_at->format('d/m/Y')}}<br>{{$store->products->count()}} produto(s)</p>
                    </div>
                </div>
            </div>
            <div class="coltable-9 pop-store-products">
                <header class="pop-title">
                    <h1>Produtos - {{$store->name}}</h1>
                </header>
                <div class="colbox">
                    @forelse($store->products as $product)
                        <div class="colbox-4">
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
                                    <img src="{{ url('imagem/produto/'.$product->galeries->first()->image) }}" alt="{{$product->name}}" title="{{$product->name}}">
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
                                    <h2><a href="{{route('pages.product',[$product->store->slug, $product->category->slug, $product->slug])}}">{{$product->name}}</a></h2>
                                </header>
                            </article>
                        </div>
                    @empty
                        <h3>Nenhum produto cadastrado nessa loja</h3>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="clear-both"></div>
    </section>
@endsection