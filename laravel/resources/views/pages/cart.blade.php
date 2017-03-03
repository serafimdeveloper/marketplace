@extends('layouts.app')

@section('content')
    <section class="content">
        @if(!Session::has('cart'))
            <div class="trigger warning">
                <p class="fontem-20">Carrinho vazio</p>
                <a href="/" class="btn btn-small btn-popmartin"><i class="fa fa-shopping-cart"></i> adicionar produto</a>
            </div>
        @else
            <header class="pop-title">
                <h1><span id="jq-count-product">{{$cart->count}}</span> item no meu carrinho</h1>
            </header>
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
                                                <span class="c-pop fontem-12 fontw-400">{{$product['name']}}</span>
                                                <br>
                                                <span>Código: 0gos8d4</span>
                                                <br>
                                                <br>
                                                <a class="pop-remove-product-cart c-pop" href="javascript:void(0)" data-product="{{$key_product}}">
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
                                            <button class="c-popdark cursor-pointer" style="background: none; border: none;">
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
                                <a href="javascript:void(0)" class="show-formobs btn btn-small btn-popmartin">{{isset($store['obs']) ? 'ver' : 'adicionar'}} observações aos produtos deste de vendedor</a>
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
                                <div>
                                    @if(isset($store['freight']))
                                    <div class="checkbox-container" style="position:relative;">
                                        <span>Frete para o CEP: <b>{{$cart->address}}</b></span>
                                        <div class="checkboxies">
                                        @foreach($store['freight'] as $key => $freight)
                                            <label class="radio" style="border: none; display: block; float: none; padding-left: 0px;">
                                                <span><span class="fa {{ ($key === 'PAC') ? 'fa-check-circle-o c-green':'fa-circle-o'}}"></span> {{$key. ': '.real($freight['val']).' ('.$freight['deadline'].' dias utéis)'}}</span>
                                                {!! Form::radio( strtolower($key), strtolower($key)) !!}
                                            </label>
                                        @endforeach
                                        </div>
                                    @endif
                                    </div>
                                </div>
                                <table>
                                    <tr>
                                        <td>Subtotal:</td>
                                        <td>{{real($store['subtotal'])}}</td>
                                    </tr>
                                    <tr class="c-bluedark">
                                        <td>Frete:</td>
                                        <td>R$ 0.00</td>
                                    </tr>
                                    <tr class="fontem-12">
                                        <td><span class="c-pop fontw-600">Total para esta loja:</span></td>
                                        <td>{{real($store['subtotal'])}}</td>
                                    </tr>
                                </table>

                                {{--<div class="colbox">--}}
                                    {{--<div class="colbox-2 txt-left">--}}
                                        {{--<p>--}}
                                            {{--<span class="vertical-middle bg-popmartin c-white padding10">FRETE: </span>--}}
                                            {{--<span class="padding10-20">GRÁTIS</span>--}}
                                            {{--<span class="padding10-20">Á CALCULAR</span>--}}
                                        {{--</p>--}}
                                    {{--</div>--}}
                                    {{--<div class="colbox-2">--}}
                                        {{--<p class="c-pop">--}}
                                            {{--<span class="">Subtotal para esta loja</span>--}}
                                            {{--<span class="fontem-16 fontw-500">{{real($store['subtotal'])}}</span>--}}
                                        {{--</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="clear-both"></div>--}}
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
            <div class="pop-cart-cep">
                <div class="txt-right">
                    {!! Form::open(['route'=>['pages.cart.add_address'],'class'=>'form-modern pop-form freight-form', 'method'=>'POST']) !!}
                        @if($addresses)
                            <span>Seleione o endereço</span>
                            {!! Form::select('address', $addresses, null, ['placeholder' => 'Selecionar endereço']) !!}
                        @else
                            <span>Informe o Cep</span>
                            {!! Form::text('address',null, ['onkeyup' => 'maskInt(this)', 'placeholder' => 'CEP']) !!}
                        @endif
                        <button type="submit" class="btn btn-popmartin">CALCULAR</button>
                    {!! Form::close() !!}
                </div>
            </div>
            <br>
            <div class="pop-cart-total">
                <div class="colbox">
                    <div class="colbox-2 txt-left">
                        <a href="/" class="btn btn-popmartin">CONTINUAR COMPRANDO</a>
                    </div>
                    <div class="colbox-2">
                        <p>Total: <span class="fontw-500 c-pop fontem-20 vertical-middle">{{real($cart->amount)}}</span>
                        </p>
                        <a href="" class="btn btn-green">FINALIZAR PEDIDO</a>
                    </div>
                </div>
                <div class="clear-both"></div>
            </div>
        @endif
    </section>
    <div class="bs-dialog radius-small" title="Enviar observação para LOJA DO JUCA"></div>
@endsection
