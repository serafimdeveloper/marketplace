@extends('layouts.app')

@section('content')
        <section class="content">
            @if(Session::has('cart'))
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
                                                <img src="{{ url('imagem/produto/'.$product['image']) }}"
                                                     alt="[]"
                                                     title="">
                                            </div>
                                            <div class="coltable-10 product-cart-info">
                                                <p class="c-pop fontem-12 fontw-400">{{$product['name']}}</p>
                                                <span>Código: 0gos8d4</span>
                                                <br>
                                                <br>
                                                <a class="pop-remove-product-cart c-pop" href="javascript:void(0)"><i
                                                            class="fa fa-trash"></i> remover</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td><label><input type="number" name="qtd" value="{{$product['qtd']}}" data-product="{{$key_product}}" class="qtd_product"></label></td>
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
                                            <span class="fontem-16 fontw-500">{{real($store['subtotal'])}}</span>
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
                        {!! Form::select('freight',$freight) !!}
                        <br>
                        <br>
                        @if($addresses)
                        {!! Form::select('address', $addresses, null, ['placeholder' => 'Selecionar endereço']) !!}
                        <span class="pop-cart-cep-ou">ou</span>
                        @else
                        {!! Form::text('cep',null, ['onkeyup' => 'maskInt(this)', 'placeholder' => 'CEP']) !!}
                        @endif
                        <button type="submit" class="btn btn-popmartin">CALCULAR</button>
                    </form>
                </div>
                <p>Frete referente a (loja do Juca) Valor <span class="fontw-500 c-pop">R$ 18,60</span></p>
                <p>Frete referente a (loja do Juca) Valor <span class="fontw-500 c-pop">R$ 24,60</span></p>
            </div>
            <br>
            <div class="pop-cart-total">
                <div class="colbox">
                    <div class="colbox-2 txt-left">
                        <a href="/" class="btn btn-popmartin">CONTINUAR COMPRANDO</a>
                    </div>
                    <div class="colbox-2">
                        <p>Total: <span class="fontw-500 c-pop fontem-20 vertical-middle">{{real($cart->amount)}}</span></p>
                        <a href="" class="btn btn-green">FINALIZAR PEDIDO</a>
                    </div>
                </div>
                <div class="clear-both"></div>
            </div>
            @endif
        </section>
        <div class="bs-dialog radius-small" title="Enviar observação para LOJA DO JUCA"></div>
@endsection
