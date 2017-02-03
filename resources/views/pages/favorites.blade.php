@extends('layouts.app')

@section('content')
    <section class="content">
        <header class="pop-title">
            <h1>Meus produtos favoritos</h1>
        </header>
        @for($i = 0; $i < 2; $i++)
            <article class="pop-cart pop-cart-info-product">
                <h1>Loja do Juca</h1>
                <div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="t-medium">Preço</th>
                        </tr>
                        </thead>
                        <tbody id="jq-pr-cart">
                        @for($j = 0; $j < 2; $j++)
                            <tr id="pr{{$j.$i}}">
                                <td>
                                    <div class="coltable">
                                        <div class="coltable-2 product-cart-img">
                                            <img src="{{ url('imagem/produto/camisa.jpg') }}"
                                                 alt="[]"
                                                 title="" style="width: 100%; max-width: 230px;">
                                        </div>
                                        <div class="coltable-10 product-cart-info">
                                            <p class="c-pop fontem-12 fontw-400"><a href="/juca/produto/nome-produto">Nome do produto</a></p>
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
    </section>
    <div class="bs-dialog radius-small" title="Enviar observação para LOJA DO JUCA"></div>
@endsection