@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Detalhe do pedido</h1>
        </header>
        <div class="padding10-20">
            <div class="coltable pop-header-request">
                <div class="coltable-8">
                    <p>
                        <span class="fontw-500">Status:</span> <span class="fontw-500 c-{{ $request->requeststatus->trigger }}">{{ $request->requeststatus->description }}</span><br>
                        <span class="fontw-500">Pedido:</span> {{ $request->key }}<br>
                        <span class="fontw-500">Data:</span> {{ $request->created_at->format('d/m/Y H:i:s') }}<br>
                        <span class="fontw-500">Loja:</span> {{ $request->store->name }}
                    </p>
                </div>
                <div class="coltable-4 txt-right">
                    <a class="btn btn-small btn-popmartin-trans txt-center jq-new-rating"><i class="fa fa-star"></i> avaliado / avaliar</a>
                    <a class="btn btn-small btn-popmartin-trans txt-center jq-new-message"><i class="fa fa-comments-o"></i> contatar o vendedor</a>
                </div>
            </div>


            <table class="table table-action">
                <thead>
                <tr>
                    <th class="t-medium" style="width: 100px;"></th>
                    <th>Produto</th>
                    <th class="t-small">Quantidade</th>
                    <th class="t-medium">Valor unitário</th>
                    <th class="t-small">Valor total</th>
                </tr>
                </thead>

                <tbody>
                @foreach($request->products as $product)
                    <tr>
                        <td class="txt-center" style="max-width: 100px;"><img src="{{ url('imagem/produto/' . $product->galeries[0]->image) }}"></td>
                        <td><a href="/loja/nome/categoria/produto" class="fontem-12" target="_blank">{{ $product->name }}</a></td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td><span class="fontem-12">R${{ number_format($product->pivot->unit_price, 2, ',', '')}}</span></td>
                        <td class="bold"><span class="fontem-12">R${{ number_format($product->pivot->amount, 2, ',', '') }}</span></td>
                    </tr>
                @endforeach
                <tr>
                    <td>Total</td>
                    <td class="bold" colspan="4" style="text-align: right;"><span class="fontem-18 fontw-800">R${{ number_format($request->amount, 2, ',', '') }}</span></td>
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
                <tr>
                    <td>{{ $request->freight->name }}</td>
                    <td>
                        <span>{{ $request->user->name }} {{ $request->user->last_name }}</span><br>
                        <span>{{ $request->adress->zip_code }} ({{ $request->adress->state }})</span><br>
                    </td>
                    <td class="bold"><span class="fontem-12">R${{ number_format($request->freight_price, 2, ',', '') }}</span></td>
                </tr>
                </tbody>
            </table>
            <hr>
            <p class="fontem-22 fontw-500">Total do pedido <span class="fl-right c-pop fontw-900">R$74,80</span></p>
            <div class="padding30"></div>
        </div>
    </section>
    <div class="clear-both"></div>
@endsection
@include('layouts.parties.alert_message')
@include('layouts.parties.alert_rating')
<div class="clear-both"></div>
