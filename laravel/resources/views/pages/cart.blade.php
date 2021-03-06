@extends('layouts.app')
@section('content')
    <section class="content">
            <header class="pop-title">
                <h1><span id="jq-count-product">{{isset($cart->count) ? $cart->count : 0 }}</span> item no meu carrinho</h1>
            </header>
            @if(Request::input('type'))
            <div class="trigger-box">
                <div class="trigger {{ Request::input('trg') }}">
                    {{ Request::input('msg') }}
                    @if(Request::input('type') == 'boleto')
                        <a class="btn btn-small btn-popmartin" href="{{ Request::input('redirectURL') }}" target="_blank">imprimir boleto</a>
                    @endif
                </div>
                @if(isset($cart->stores))
                    <p class="padding10 txt-center">continue com suas compras <i class="fa fa-hand-o-down"></i></p>
                @endif
            </div>
            @endif
        @if(!Session::has('cart') || !(count($cart->stores)))
            <div class="trigger warning">
                <span class="fontem-36"><i class="fa fa-frown-o" aria-hidden="true"></i></span><br>
                <span class="fontem-18">Carrinho vazio</span><br><br>
                <a href="/" class="btn btn-small btn-popmartin-trans">
                    <i class="fa fa-cart-plus" aria-hidden="true"></i>
                    adicionar produtos
                </a>
            </div>
        @else
            @foreach($cart->stores as $key_store => $store )
                <article class="pop-cart">
                    <h1>{{$store['name']}}</h1>
                    <div>
                        <table class="table pop-cart-info-product">
                            <thead>
                            <tr>
                                <th></th>
                                <th class="t-medium">Frete</th>
                                <th class="t-medium">Quantidade</th>
                                <th class="t-medium">Preço Unitário</th>
                                <th class="t-medium">Subtotal</th>
                            </tr>
                            </thead>
                            <tbody id="jq-pr-cart">
                            @foreach($store['products'] as $key_product => $product)
                                <tr id="pr{{$key_store.$key_product}}">
                                    <td>
                                        <div class="coltable">
                                            <div class="coltable-2 product-cart-img">
                                                <img src="{{ url('imagem/produto/'.$product['image'] . '?w120&h=120&fit=cropt') }}"
                                                     alt="[]"
                                                     title="">
                                            </div>
                                            <div class="coltable-10 product-cart-info">
                                                <a href="{{route('pages.product',['store' => $store['slug'], 'category' => $product['category'], 'product' => $product['slug']])}}"
                                                   target="_blank"><span
                                                            class="c-pop fontem-12 fontw-400">{{$product['name']}}</span></a>
                                                <br>
                                                <br>
                                                <a class="pop-remove-product-cart c-pop" href="javascript:void(0)"
                                                   data-product="{{$key_product}}">
                                                    <i class="fa fa-trash"></i> remover</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ ($product['free_shipping'] ? 'Grátis' : 'á calcular') }}</td>
                                    <td class="txt-center">
                                        <form action="javascript:void(0)" class="atualizar-produtos">
                                            <label>
                                                <input type="number" name="qtd" value="{{$product['qtd']}}">
                                            </label>
                                            <input type="hidden" name="product" value="{{$key_product}}"/>
                                            {{csrf_field()}}
                                            <br>
                                            <button class="c-popdark cursor-pointer"
                                                    style="background: none; border: none;">
                                                <i class="fa fa-refresh"></i>
                                                atualizar
                                            </button>
                                        </form>
                                    </td>
                                    <td class="price">{{real($product['price_unit'])}}</td>
                                    <td class="price" style="font-weight: bold;">{{real($product['subtotal'])}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pop-cart-footer">
                            <div class="pop-cart-obs">
                                <a href="javascript:void(0)"
                                   class="show-formobs btn btn-small btn-popmartin-trans"><i class="fa fa-comments"></i>
                                    {{isset($store['obs']) ? 'ver' : 'adicionar'}}
                                    observações a este pedido</a>
                                <form class="form-modern" action="" method="POST">
                                    {{csrf_field()}}
                                    <input type="hidden" name="store" value="{{$key_store}}">
                                    <label>
                                        <textarea name="note" class="radius"
                                                  placeholder="Exemplo: tamanho, cor, outra informação">{{$store['obs']}}</textarea>
                                    </label>
                                    <div class="">
                                        <button type="submit" class="btn btn-small btn-popmartin">Salvar</button>
                                        <a href="javascript:void(0)" class="c-red">cancelar</a>
                                    </div>
                                </form>
                            </div>
                            <div class="pop-cart-subtotal">
                                <div class="colbox">
                                    <div class="colbox-2">
                                        <p class="txt-right" style="margin: 30px 0 20px 0;">
                                            @if(isset($cart->address['zip_code']) && isset($address[0]))
                                                <span class="fontem-16">Frete para o CEP: <b>{{$cart->address['zip_code']}}</b></span>
                                                <br>
                                                <span>{{$address[0]['logradouro'].', '.$address[0]['bairro'].', '.$address[0]['cidade'].' - '.$address[0]['uf']}}</span>
                                            @else
                                                <span class="fontem-16">Nenhum endereço encontrado</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="colbox-2">
                                        @if(isset($store['freight']))
                                            <table>
                                                <tr>
                                                    <td>Subtotal:</td>
                                                    <td>{{real($store['subtotal'])}}</td>
                                                </tr>
                                            </table>
                                            <br>
                                            <div class="checkbox-container dp-inblock txt-right">
                                                <div class="checkboxies txt-left">
                                                    @foreach($store['freight'] as $key => $freight)
                                                        <label class="radio" style="float: none; display: block;">
                                                        <span>
                                                            <i class="fa {{ ($key === $store['type_freight']['name']) ? 'fa-check-circle-o c-green':'fa-circle-o'}}"></i>
                                                            {{(($key === 'FREE') ? 'FRETE GRÁTIS': $key). ': '.real($freight['val']).' ('.$freight['deadline'].' dias utéis)'}}
                                                        </span>
                                                            {!! Form::radio('type_freight', $key, ($key === $store['type_freight']['name']), ['class'=>'type-freight', 'data-store' => $key_store, 'data-token' => csrf_token(), 'data-id' => $freight['id'] ] ) !!}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <br>
                                        @endif
                                        <table>
                                            <tr class="fontem-12">
                                                <td><span class="c-pop fontw-600">Total para esta loja:</span></td>
                                                <td>{{real($store['amount'])}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="clear-both"></div>
                            </div>
                        </div>
                    </div>
                    <div class="txt-right">
                        @if($cart->address)
                            <a href="{{ route('pages.cart.cart_address', ['sha1' => strtoupper(sha1($key_store))])}}" class="btn btn-popmartin">enviar pedido desta loja</a>
                        @else
                            <span class="btn btn-gray cursor-nodrop tooltip" title="Necessário informar um cep">enviar pedido</span>
                        @endif
                    </div>
                </article>
            @endforeach
        <hr>
            <div class="pop-cart-cep">
                <div class="txt-right">
                    {!! Form::open(['route'=>['pages.cart.add_address'],'class'=>'form-modern pop-form freight-form', 'method'=>'POST']) !!}
                    @if($addresses)
                        <span>Selecione o endereço</span>
                        {!! Form::select('address', $addresses, (isset($cart->address['id']) ? $cart->address['id'] : null), ['class' => 'selectAddressCart', 'placeholder' => 'Selecionar endereço']) !!}
                        <label style="display: inline-block;width: auto;">
                            {!! Form::text('zip_code',(isset($cart->address['zip_code']) ? $cart->address['zip_code'] : null), ['class' => 'getCepAddressCart', 'onkeyup' => 'maskInt(this)', 'placeholder' => 'CEP', 'data-minlength' => 8]) !!}
                            <!--<span class="alert {{ $errors->has('zip_code') ? '' : ' hidden' }}">{{ $errors->first('zip_code') }}</span>-->
                        </label>

                    @else
                        <span>Informe o Cep</span>
                        {!! Form::text('zip_code', (isset($cart->address['zip_code']) ? $cart->address['zip_code'] : null), ['onkeyup' => 'maskInt(this)', 'placeholder' => 'CEP']) !!}
                        <!--<span class="alert{{ $errors->has('zip_code') ? '' : ' hidden' }}">{{ $errors->first('zip_code') }}</span>-->
                    @endif
                    <button type="submit" class="btn btn-popmartin">calcular</button>
                    {!! Form::close() !!}
                </div>
            </div>
            <br>
            <div class="pop-cart-total">
                <p class="pop-cart-subtotal">Total:
                    <span class="fontw-500 c-pop fontem-12 vertical-middle">{{real($cart->amount)}}</span>
                </p>
                <div class="colbox">
                    <div class="colbox-2 txt-left">
                        <br>
                        <a href="/" class="c-pop"><i class="fa fa-chevron-left vertical-middle"></i> continuar comprando</a>
                    </div>
                    {{--<div class="colbox-2">--}}
                        {{--@if($cart->address)--}}
                            {{--<a href="{{ route('pages.cart.cart_address') }}" class="btn btn-popmartin">enviar--}}
                                {{--pedido</a>--}}
                        {{--@else--}}
                            {{--<span class="btn btn-gray cursor-nodrop tooltip" title="Necessário informar um cep">enviar pedido</span>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                </div>
                <div class="clear-both"></div>
            </div>
        @endif
    </section>
    <div class="bs-dialog radius-small" title="Enviar observação para LOJA DO JUCA"></div>
@endsection
