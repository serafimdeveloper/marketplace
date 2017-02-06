@extends('layouts.app')

@section('content')
    <section class="content">
        <header class="pop-title">
            <h1>Meus produtos favoritos</h1>
        </header>
        @for($i = 0; $i < 2; $i++)
            <article class="pop-cart pop-favrities">
                <h1>Loja do Juca</h1>
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
                        @for($j = 0; $j < 2; $j++)
                            <tr id="pr{{$j.$i}}">
                                <td class="txt-center">
                                    <div class="form-modern">
                                        <div class="checkbox-container">
                                            <div class="checkboxies">
                                                <label class="checkbox" style="border: none;padding: 0;">
                                                    <span><span class="fa fa-square-o"></span></span>
                                                    {!! Form::checkbox('status','0') !!}
                                                </label>
                                            </div>
                                            <span class="alert hidden"></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="coltable">
                                        <div class="coltable-2 product-cart-img">
                                            <img src="{{ url('imagem/produto/camisa.jpg') }}"
                                                 alt="[]"
                                                 title="">
                                        </div>
                                        <div class="coltable-10 product-cart-info">
                                            <p class="c-pop fontem-12 fontw-400">Nome do produto</p>
                                            <span>Código: 0gos8d4</span>
                                            <br>
                                            <br>
                                            <a class="pop-remove-product-cart c-pop" href="javascript:void(0)"><i
                                                        class="fa fa-trash"></i> remover</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="price" style="font-weight: bold;">R$ 14,90</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
                </div>
            </article>
        @endfor
        <a href="javascript:void(0)" class="btn btn-popmartin">adicionar ao carrinho</a>
    </section>
    <div class="bs-dialog radius-small" title="Enviar observação para LOJA DO JUCA"></div>
@endsection