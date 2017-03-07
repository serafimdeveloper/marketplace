@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="pop-title">
            <h1>Finalizar pedido</h1>
        </div>
        <br>
        <p class="txt-center fontem-14 fontw-500 c-graydark">Valor:
            <span class="c-pop">R$287,00</span>
        </p>
        <hr>
        <br>
        <div class="colbox">
            <div class="colbox-2">
                <h2 class="c-pop fontem-10">Escolher o meio de pagamento</h2>
                <a href="javascript:void(0)" class="btn btn-popmartin-trans">
                    <i class="fa fa-credit-card"></i>
                    cartão de crédito</a>
                <a href="javascript:void(0)" class="btn btn-popmartin-trans">
                    <i class="fa fa-barcode"></i>
                    boleto</a>
                <p></p>
                {{--<h2 class="c-pop fontem-10">Débito online</h2>--}}
                {{--<a href="" class="btn btn-popmartin-trans">Itaí</a>--}}
                {{--<a href="" class="btn btn-popmartin-trans">Brasil</a>--}}
                {{--<a href="" class="btn btn-popmartin-trans">Bradesco</a>--}}
                {{--<a href="" class="btn btn-popmartin-trans">Caixa</a>--}}
            </div>
            <div class="colbox-2">
                <h2 class="c-pop fontem-10">Dados da entrega</h2>
                <br>
                <div class="colbox">
                    <div class="colbox-full">
                        <p><span class="fontw-500 c-graydark">Prazo de entrega:</span> prazo de postagem da loja + 3 dias</p>
                        <p><span class="fontw-500 c-graydark">Endereço:</span>
                            Rua Don Antônio Cabral 117, São Luíz, Volta Redonda - RJ
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear-both"></div>
        <br>
        <hr>
        <br>
        <h2 class="c-pop fontem-10">Dados dos produtos</h2>
        <br>
        @for($i=0;$i<2;$i++)
            <div class="padding15-30">
                <div class="colbox">
                    <div class="colbox-2">
                        <img src="{{ url('/imagem/loja/8b83714c7d5b66a44a6076b6a7e5ccc2.jpg?w=50&h=50&fit=crop') }}" title=""
                             alt="[nome da loja]" class="vertical-middle">
                        <p class="dp-inblock vertical-middle">
                            <span class="fontem-14">Nome da Loja</span><br>
                            <span class="dp-inblock"><b class="c-graydark">Pedido</b> nº FHBY676IU -</span>
                            <span class="dp-inblock"><b class="c-graydark">Data</b> 02/25/1669</span>
                        </p>
                    </div>
                    <div class="colbox-2">
                        <span><span class="fontw-500 c-graydark">Forma de envio:</span> PAC</span>
                        <br>
                        <span><span class="fontw-500 c-graydark">Prazo de postagem:</span> 1 dias</span>
                    </div>
                </div>
                <div class="clear-both"></div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>Produto</th>
                    <th>quantidade</th>
                    <th>valor unitário</th>
                    <th>subtotal</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>nome do produto</td>
                    <td>2</td>
                    <td>R$ 25,90</td>
                    <td>R$ 51,80</td>
                </tr>
                <tr>
                    <th>nome do produto</th>
                    <td>2</td>
                    <td>R$ 25,90</td>
                    <td>R$ 51,80</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right">frete</td>
                    <td>R$ 19,90</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right">Total</td>
                    <td>R$ 143,50</td>
                </tr>
                </tbody>
            </table>
        @endfor
        <div class="colbox-2">
            <br>
            <a href="/carrinho" class="c-pop"><i class="fa fa-chevron-left"></i> Voltar para o carrinho</a>
        </div>
        <div class="padding20"></div>
    </section>
@endsection
