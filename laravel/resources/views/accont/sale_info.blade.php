@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Detalhes da venda</h1>
        </header>
        <div class="padding10-20">
            <div class="colbox">
                <div class="colbox-2">
                    <p>
                        <span class="fontw-500">Status:</span><span class="fontw-600 c-{{ $request->requeststatus->trigger }}"> {{ $request->requeststatus->description }} </span><br>
                        {{--{{isset($rastreamento[0]) ? $rastreamento[0]->status :'aguardando envio'}}--}}
                        <span class="fontw-500">Pedido N°:</span> {{$request->key}}<br>
                        <span class="fontw-500">Data:</span> {{$request->created_at->diffForHumans()}}<br>
                        <span class="fontw-500">Cliente:</span> {{$request->user->name.' '.$request->user->last_name}}
                    </p>
                </div>
                <div class="colbox-2">
                    {!! Form::model($request, ['route' => ['accont.salesman.request.tracking_code', $request->id],'id' =>'form-tracking' ,'class' => 'form-modern pop-form pst-relative pop-tracking'] ) !!}
                        <label>
                            <span>Código de rastreio dos correios</span>
                            {!! Form::text('tracking_code', null, ['placeholder' => 'código']) !!}
                            <span class="alert hidden"></span>
                            <span class="fa fa-spinner fa-spin jq-loader dp-none loader-2"></span>
                        </label>
                        <button type="submit" class="btn btn-small btn-popmartin">enviar</button>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="clear-both"></div>
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
                @forelse($request->products as $product)
                    <tr>
                        <td><img src="{{ url('imagem/produto/'.$product->galeries->first()->image) }}"></td>
                        <td><a href="/loja/nome/categoria/produto" class="fontem-12" target="_blank">{{$product->name}}</a></td>
                        <td>{{$product->pivot->quantity}}</td>
                        <td><span class="fontem-12">R${{number_format($product->pivot->unit_price,2,',','.')}}</span></td>
                        <td class="t-active bold"><span class="fontem-12">R${{ number_format($product->pivot->amount,2,',',',') }}</span></td>
                    </tr>
                @empty
                @endforelse
                <tr>
                    <td>Total</td>
                    <td class="t-active bold" colspan="4"><span class="fontem-18 fontw-800">R${{number_format(amount_products($request->products),2,',','.')}}</span></td>
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
                    <td>{{$request->freight->name}}</td>
                    <td>
                        <span>{{$request->user->name.' '.$request->user->last_name}}</span><br>
                        <span>{{$request->adress->zip_code}} ({{$request->adress->state}})</span><br>
                    </td>
                    <td class="t-active bold"><span class="fontem-12">R${{number_format($request->freight_price,2,',','.')}}</span></td>
                </tr>
                </tbody>
            </table>
            <hr>
            <p class="fontem-22 fontw-500">Total do pedido <span class="fl-right c-green fontw-900">R${{number_format(amount_products_final($request->products,$request->freight_price),2,',','.')}}</span></p>
            <div class="clear-both"></div>
        </div>
        <div class="content">
            <h4>Anotações do cliente</h4>
            <p class="padding20-40 bg-graylightextreme">
                {{ $request->note }}
            </p>
        </div>
        <div class="txt-center">
            <a href="{{route('accont.salesman.etiqueta', ['id' => $request->id])}}" class="btn btn-popmartin" target="_blank">Gerar etiqueta</a>
        </div>
        <div class="padding20"></div>
    </section>
    <div class="clear-both"></div>
@endsection
