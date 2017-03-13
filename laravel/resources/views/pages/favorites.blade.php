@extends('layouts.app')

@section('content')
    <section class="content">
        <header class="pop-title">
            <h1>Meus produtos favoritos</h1>
        </header>
        @forelse($favorites as $key_store => $store)
            <article class="pop-cart pop-favrities">
                <h1>{{$store['store']->name}}</h1>
                <div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="t-small"></th>
                            <th></th>
                            <th class="t-medium">Preço</th>
                        </tr>
                        </thead>
                        <tbody id="jq-pr-cart">
                        @forelse($store['products'] as  $product)
                            <tr id="pr{{$product->id}}">
                                <td class="txt-center">
                                    <div class="form-modern">
                                        <div class="checkbox-container">
                                            <div class="checkboxies">
                                                <label class="checkbox" style="border: none;padding: 0;">
                                                    <span><span class="fa fa-square-o"></span></span>
                                                    {!! Form::checkbox('status',$product->id) !!}
                                                </label>
                                            </div>
                                            <span class="alert hidden"></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="coltable">
                                        <div class="coltable-2 product-cart-img">
                                            <img src="{{ url('imagem/produto/'.$product->galeries->first()->image) }}"
                                                 alt="{{$product->name}}"
                                                 title="{{$product->name}}">
                                        </div>
                                        <div class="coltable-10 product-cart-info">
                                            <p><a href="{{route('pages.product',['store' => $store['store']->slug, 'category' => $product->category->slug, 'product' => $product->slug])}}" class="c-pop fontem-12 fontw-400">{{$product->name}}</a></p>.
                                            <span>Código: 0gos8d4</span>
                                            <br>
                                            <br>
                                            <a class="pop-remove-product-favorite c-pop" data-product="{{$product->id}}" href="javascript:void(0)"><i
                                                        class="fa fa-trash"></i> remover</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="price" style="font-weight: bold;">{{isset($product->price_out_discount) ? real($product->price_out_discount) : real($product->price)}}</td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
                </div>
            </article>
        @empty
        @endforelse
        <a href="javascript:void(0)" class="btn btn-popmartin">adicionar ao carrinho</a>
    </section>
    <div class="bs-dialog radius-small" title="Enviar observação para LOJA DO JUCA"></div>
@endsection