@extends('layouts.app')
@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Detalhe do pedido</h1>
        </header>
        <div class="padding10-20">
            <div class="coltable pop-header-request" style="margin-bottom: 10px">
                <div class="coltable-6">
                    <p>
                        <span class="fontw-500">Status:</span> <span
                                class="fontw-500 c-{{ $request->requeststatus->trigger }}">{{ $request->requeststatus->description }}</span><br>
                        <span class="fontw-500">Pedido:</span> {{ $request->key }}<br>
                        <span class="fontw-500">Data:</span> {{ $request->created_at->format('d/m/Y H:i:s') }}<br>
                        <span class="fontw-500">Loja:</span> {{ $request->store->name }}</br>
                        <span class="fontw-500">Forma de pagamento:</span> {{ $request->payment_reference }}
                        @if($request->request_status_id == 2)
                            <a href="{{ route('pages.cart.cart_order', ['order_key' => $request->key]) }}"
                               class="btn btn-smallextreme btn-popmartin">pagar</a>
                        @elseif($request->request_status_id == 1)
                            @if($request->payment_reference == 'boleto')
                                | <a href="{{ $request->moip->url }}" class="c-pop fontem-08" target="_blank"><i
                                            class="fa fa-print"></i> imprimir 2° via</a>
                            @else
                                <a href="{{ route('pages.cart.cart_order', ['order_key' => $request->key]) }}"
                                   class="btn btn-smallextreme btn-popmartin">pagar</a>
                            @endif
                        @elseif($request->request_status_id == 3)
                            <span class="c-green"><i class="fa fa-check"></i> pago</span>
                        @elseif($request->request_status_id == 6)
                            <span class="c-red"><i class="fa fa-close"></i> cancelado</span>
                            <a href="{{ route('pages.cart.cart_order', ['order_key' => $request->key]) }}"
                               class="btn btn-smallextreme btn-popmartin">pagar</a>
                        @endif
                    </p>
                </div>
                <div class="coltable-6 txt-right">
                    @if($request->request_status_id > 4)
                        <a class="btn btn-small btn-popmartin-trans txt-center alertbox-open" data-alertbox="alert-rating">
                            <i class="fa fa-star"></i> {{ (isset($request->shopvaluation) ? 'avaliado' : 'avaliar') }}
                        </a>
                    @endif
                    <a class="btn btn-small btn-popmartin-trans txt-center alertbox-open" data-alertbox="alert-message"><i
                                class="fa fa-comments-o"></i> contatar o vendedor</a>
                    @if($request->request_status_id === 4)
                        <span style="margin-bottom: 10px" class="txt-left">
                                <p style="margin-bottom: 0">Status: <strong>{{$request->object->status}}</strong></p>
                                <p style="margin-bottom: 0">Código de rastreio: {{ mb_strtoupper($request->tracking_code)}}</p>
                                <p style="margin-bottom: 0">Data: {{$request->object->data}}
                                    -  Local: {{$request->object->local}}</p>
                                <p style="margin-bottom: 0">{{ $request->object->encaminhado }}</p>
                            </span>
                    @endif
                </div>
            </div>

            <table class="table table-action">
                <thead>
                <tr>
                    <th class="t-medium" style="width: 100px;"></th>
                    <th>Produto</th>
                    <th class="t-small">Quantidade</th>
                    <th class="t-medium">Valor unitário</th>
                    <th class="t-medium">Valor total</th>
                </tr>
                </thead>

                <tbody>
                @foreach($request->products as $product)
                    <tr>
                        <td class="txt-center" style="max-width: 100px;"><img
                                    src="{{ url('imagem/produto/' . $product->galeries[0]->image.'?w=60&h=60&fit=crop') }}">
                        </td>
                        <td>
                            <a href="{{route('pages.product',[$request->store->slug, $product->category->slug, $product->slug])}}"
                               class="fontem-12" target="_blank">{{ $product->name }}</a></td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td><span class="fontem-12">{{ real($product->pivot->unit_price)}}</span></td>
                        <td class="bold"><span class="fontem-12">{{ real($product->pivot->amount) }}</span></td>
                    </tr>
                @endforeach
                <tr>
                    <td>Total</td>
                    <td class="bold" colspan="4" style="text-align: right;"><span
                                class="fontem-18 fontw-800">{{real(amount_products($request->products))}}</span></td>
                </tr>
                </tbody>
            </table>
            <table class="table table-action">
                <thead>
                <tr>
                    <th class="t-small">Frete</th>
                    <th>destino</th>
                    <th class="t-small">Total</th>
                </tr>
                </thead>

                <tbody>
                @if($address['receiver'])
                    <tr>
                        <td>{{ $request->freight->name }}</td>
                        <td>
                            <span>{{ $address['receiver']->name }}</span><br>
                            <span>{{ $address['receiver']->zip_code }} ({{ $address['receiver']->state }})</span><br>
                        </td>
                        <td class="bold"><span
                                    class="fontem-12">R${{ number_format($request->freight_price, 2, ',', '') }}</span>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
            @if($request->amount_interest > 0)
                <table class="table table-action">
                    <thead>
                    <tr>
                        <th>Outros valores</th>
                        <th class="t-small">Total</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>Juros de cartão de crédito em {{ $request->number_installments}}x</td>
                        <td class="bold">
                            <span class="fontem-12">R${{ number_format($request->amount_interest, 2, ',', '') }}</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            @endif
            <hr>
            <p class="fontem-22 fontw-500">Total do pedido <span
                        class="fl-right c-pop fontw-900">R${{number_format(amount_products_final($request->products,$request->freight_price) + $request->amount_interest,2,',','.')}}</span>
            </p>
            <div class="padding10"></div>
            @if($request->note)
                <div class="content">
                    <h4>Anotações enviada junto ao pedido</h4>
                    <p class="padding20-40 bg-graylightextreme">
                        {{ $request->note }}
                    </p>
                </div>
            @endif
        </div>
    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_rating')
    @include('layouts.parties.alert_message')
@endsection

