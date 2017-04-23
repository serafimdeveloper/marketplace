@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="pop-title">
            <h1>Finalizar pedido</h1>
        </div>
        <br>
        <p class="txt-center fontem-14 fontw-500 c-graydark">Valor:
            <span class="c-pop">{{real($order->amount)}}</span>
        </p>
        <hr>
        <br>
        <div class="colbox">
            <div class="colbox-2">
                <h2 class="c-pop fontem-10">Escolher o meio de pagamento</h2>
                @if($order->request_status_id < 3)
                <br>
                <a href="javascript:addCredencies()" id="addCredencies" class="btn btn-popmartin-trans">
                    <i class="fa fa-credit-card"></i> cartão de crédito
                </a>
                <a href="javascript:payBillet()" class="btn btn-popmartin-trans">
                    <i class="fa fa-barcode"></i> boleto
                </a>
                @else
                    <div class="trigger accept"><i class="fa fa-check"></i> Pago</div>
                @endif
                <p></p>
            </div>
            <div class="colbox-2">
                <h2 class="c-pop fontem-10">Dados da entrega</h2>
                <br>
                <div class="colbox">
                    <div class="colbox-full">
                        <span><span class="fontw-500 c-graydark">Forma de envio: </span>{{$order->freight->name}}</span>
                        <br>
                        <span><span class="fontw-500 c-graydark">Prazo de postagem:</span> {{$deadline}}
                            dias úteis</span>
                        <br>
                        <span class="fontw-500 c-graydark">Prazo de entrega:</span> prazo de postagem da loja
                        + {{$order->deadline}} dias
                        <br>
                        <p><span class="fontw-500 c-graydark">Endereço:</span>
                            @if($address['receiver'])
                                {{$address['receiver']['public_place'].', '.$address['receiver']['number'].(($address['receiver']['complements'])
                                ? ' ('.$address['receiver']['complements'].')' : '')
                                .', '.$address['receiver']['neighborhood'].', '.$address['receiver']['city'].' - '.$address['receiver']['state']}}
                            @endif
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
        <div class="padding15-30">
            <div class="colbox">
                <div class="colbox-2">
                    <img src="{{ url('/imagem/loja/'.$order->store->logo_file.'?w=50&h=50&fit=crop') }}" title=""
                         alt="{{$order->store->name}}" class="vertical-middle">
                    <p class="dp-inblock vertical-middle">
                        <span class="fontem-14">{{$order->store->name}}</span><br>
                        <span class="dp-inblock"><b class="c-graydark">Pedido</b> nº: {{$order->key}} -</span>
                        <span class="dp-inblock"><b
                                    class="c-graydark">Data:</b> {{$order->created_at->format('d/m/Y H:i:s')}}</span>
                    </p>
                </div>
                <div class="colbox-2">

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
            @foreach($order->products as $product)
                <tr>
                    <td>{{$product->name}}</td>
                    <td>{{$product->pivot->quantity}}</td>
                    <td>{{real($product->pivot->unit_price)}}</td>
                    <td>{{real($product->pivot->amount)}}</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="3" style="text-align: right">frete</td>
                <td>{{real($order->freight_price)}}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right">Total</td>
                <td>{{real($order->amount)}}</td>
            </tr>
            </tbody>
        </table>
        <div class="colbox-2">
            <br>
            <a href="/carrinho" class="c-pop"><i class="fa fa-chevron-left"></i> Voltar para o carrinho</a>
        </div>
        <div class="padding20"></div>
    </section>
    @include('layouts.parties.data_moip_checkout')
@endsection

