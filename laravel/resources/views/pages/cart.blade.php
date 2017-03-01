@extends('layouts.app')

@section('content')
    <section class="content jq-cart">
        <header class="pop-title">
            <h1><span id="jq-count-product">0</span> item no carrinho</h1>
            {{--{{ ($cart ? count($cart->stores->products) : 0) }}--}}
        </header>
        @if(!$cart)
            <div class="txt-center">
                <p class="trigger notice fontem-24">Carrinho Vazio!<br>
                    <a href="/" class="btn btn-small btn-popmartin" style="font-size: 0.5em;">
                        <i class="fa fa-shopping-cart"></i>
                        Adicionar produtos
                    </a>
                </p>
            </div>
        @else
            @foreach($cart->stores as $store)
                <article class="pop-cart">
                    <h1>{{$store['name']}}</h1>
                    <div>
                        <table class="table pop-cart-info-product">
                            <thead>
                            <tr>
                                <th></th>
                                <th class="t-medium">Quantidade</th>
                                <th class="t-medium">Preço Unitário</th>
                                <th class="t-medium">Subtotal</th>
                            </tr>
                            </thead>
                            <tbody id="jq-pr-cart">
                            @foreach($store['products'] as $product)
                                <tr id="pr{{key($store).key($product)}}" class="product-cart">
                                    <td>
                                        <div class="coltable">
                                            <div class="coltable-2 product-cart-img">
                                                <img src="{{ url('imagem/produto/'.$product['image'] . '?w=100&h=100&fit=crop') }}"
                                                     alt="[]"
                                                     title="">
                                            </div>
                                            <div class="coltable-10 product-cart-info">
                                                <span class="c-pop fontem-12 fontw-400">{{$product['name']}}</span><br>
                                                <span>Código: 0gos8d4</span>
                                                <br>
                                                <br>
                                                <p>
                                                    <a class="pop-remove-product-cart c-pop" href="javascript:void(0)">
                                                        <i class="fa fa-trash"></i> remover
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </td>
                                    <td>
                                        <label>
                                            <input type="number" name="" value="{{$product['qtd']}}">
                                        </label>
                                    </td>
                                    <td class="price">
                                        R$ {{$product['price_unit']}}
                                    </td>
                                    <td class="price" style="font-weight: bold;">R$ {{$product['subtotal']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pop-cart-footer">
                            <div class="pop-cart-obs">
                                <a href="javascript:void(0)" class="show-formobs btn btn-small btn-popmartin">adicionar
                                    observação aos produtos deste de vendedor</a>
                                <form class="form-modern" action="" method="POST">
                                    <input type="hidden" name="store" value="1">
                                    <label>
                                    <textarea name="note" class="radius"
                                              placeholder="Exemplo: tamanho, cor, outra informação"></textarea>
                                    </label>
                                    <div class="">
                                        <button type="submit" class="btn btn-small btn-popmartin">Salvar</button>
                                        <a href="javascript:void(0)" class="c-red">cancelar</a>
                                    </div>
                                </form>
                            </div>
                            <div class="pop-cart-subtotal">
                                <div class="colbox">
                                    <div class="colbox-2 txt-left">
                                        <p>
                                            <span class="vertical-middle bg-popmartin c-white padding10">FRETE: </span>
                                            {{--<span class="padding10-20">GRÁTIS</span>--}}
                                            <span class="padding10-20">Á CALCULAR</span>
                                        </p>
                                    </div>
                                    <div class="colbox-2">
                                        <p class="c-pop">
                                            <span class="">Subtotal para esta loja</span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <span class="fontem-16 fontw-500">R$ {{$store['subtotal']}}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="clear-both"></div>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
            <div class="pop-cart-cep">
                <div class="txt-right">
                    <form class="form-modern pop-form freight-form">
                        <span>Forma de frete</span>
                        <select name="freight-type">
                            @foreach($freights as $freight)
                                <option value="{{ $freight->code }}" selected="true">{{ $freight->name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <br>
                        @if($addresses)
                            <select class="freight-address">
                                <option selected disabled>selecionar endereço</option>
                                @foreach($addresses as $address)
                                    <option value="{{ $address->zip_code }}">{{ $address->name }}</option>
                                @endforeach
                            </select>
                            <span class="pop-cart-cep-ou">ou</span>
                        @endif
                        {!! Form::text('cep',null, ['onkeyup' => 'maskInt(this)', 'placeholder' => 'CEP', 'class' => 'freight-cep', 'maxlength' => 8]) !!}
                        <button type="submit" class="btn btn-popmartin">CALCULAR</button>
                    </form>
                </div>
                <div class="freight-calculation dp-none">
                    <p>Frete referente a (loja do Juca) Valor <span class="fontw-500 c-pop">R$ 18,60</span></p>
                </div>
            </div>
            <br>
            <div class="pop-cart-total">
                <div class="colbox">
                    <div class="colbox-2 txt-left">
                        <a href="/" class="btn btn-popmartin">CONTINUAR COMPRANDO</a>
                    </div>
                    <div class="colbox-2">
                        <p>Total: <span class="fontw-500 c-pop fontem-20 vertical-middle">R$ {{$cart->amount}}</span>
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