@extends('layouts.app')

@section('content')
    <section class="content">
        <header class="pop-title">
            <h1><span id="jq-count-product">1</span> item no meu carrinho</h1>
        </header>
        @for($i = 0; $i < 2; $i++)
            <article class="pop-cart">
                <h1>Loja do Juca</h1>
                <div>
                    <table class="table pop-cart-info-product">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="t-medium">Prazo de entrega</th>
                            <th class="t-medium">Quantidade</th>
                            <th class="t-medium">Preço Unitário</th>
                            <th class="t-medium">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody id="jq-pr-cart">
                        @for($j = 0; $j < 2; $j++)
                            <tr id="pr{{$j.$i}}">
                                <td>
                                    <div class="coltable">
                                        <div class="coltable-4">
                                            <img src="{{ url('imagem/produto/camisa.jpg?w=300&h=200&fit=crop') }}"
                                                 alt="[]"
                                                 title="">
                                        </div>
                                        <div class="coltable-8">
                                            <p class="c-pop fontem-12 fontw-400">Nome do produto</p>
                                            <span>Código: 0gos8d4</span>
                                            <br>
                                            <br>
                                            <a class="pop-remove-product-cart c-pop" href="javascript:void(0)"><i
                                                        class="fa fa-trash"></i> remover</a>
                                        </div>
                                    </div>
                                </td>
                                <td>5 dias</td>
                                <td><label><input type="number" name="" value="1"></label></td>
                                <td class="price">R$ 14,90</td>
                                <td class="price" style="font-weight: bold;">R$ 14,90</td>
                            </tr>
                        @endfor
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
                                        <span class="fontem-16 fontw-500">R$ 58,00</span>
                                    </p>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>
                    </div>
                </div>
            </article>
        @endfor
        <div class="pop-cart-cep">
            <div class="txt-right">
                <form class="form-modern pop-form">
                    <span>Forma de frete</span>
                    <select name="freight">
                        <option value="1" selected="true">PAC - envio normal</option>
                        <option value="1">SEDEX - envio rápido</option>
                    </select>
                    <br>
                    <br>
                    <select name="address">
                        <option selected disabled>selecionar endereço</option>
                        <option value="1">endereço 1</option>
                        <option value="1">endereço 2</option>
                        <option value="1">endereço 3</option>
                    </select>
                    <span class="pop-cart-cep-ou">ou</span>
                    {!! Form::text('cep',null, ['onkeyup' => 'maskInt(this)', 'placeholder' => 'CEP']) !!}

                    <button type="submit" class="btn btn-popmartin">CALCULAR</button>
                </form>
            </div>
            <p>Frete referente a (loja do Juca) Valor <span class="fontw-500 c-pop">R$ 18,60</span></p>
            <p>Frete referente a (loja do Juca) Valor <span class="fontw-500 c-pop">R$ 24,60</span></p>
        </div>
        <br>
        <div class="pop-cart-total">
            <p>Total: <span class="fontw-500 c-pop fontem-20 vertical-middle">R$ 24,60</span></p>
            <a href="" class="btn btn-green">FINALIZAR PEDIDO</a>
        </div>
    </section>
    <div class="bs-dialog radius-small" title="Enviar observação para LOJA DO JUCA"></div>
@endsection