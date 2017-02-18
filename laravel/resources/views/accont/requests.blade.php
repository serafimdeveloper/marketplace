@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Meus pedidos</h1>
        </header>

    @if(!$requests)
            <p class="trigger notice fontem-14">Você não realizou compras no site ainda<br>
                <a class="btn btn-small btn-popmartin" href="{{ route('homepage') }}" target="_blank">Comprar agora</a>
            </p>
        @else
        <!-- TABLE -->
            <table class="table table-action">

                <thead>
                <tr>
                    <th class="t-small">Pedidos</th>
                    <th class="t-medium">Data</th>
                    <th class="t-medium">Valor</th>
                    <th class="t-medium">Loja</th>
                    <th class="t-medium">Status</th>
                    <th class="t-small"></th>
                </tr>
                </thead>

                <tbody>
                @foreach($requests as $order)
                    <tr>
                        <td>{{ $order->key }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
                        <td>R$ {{ $order->amount }}</td>
                        <td>{{ $order->store->name }}</td>
                        <td class="t-status t-{{ $order->requeststatus->trigger }}">{{ $order->requeststatus->description }}</td>
                        <td class="txt-center"><a href="/accont/requests/{{ $order->id }}"
                                                  class="t-popmartin">detalhes</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!-- END TABLE -->

            <div class="fl-right">{!! $requests->render() !!}</div>
        @endif
    </section>
    <div class="clear-both"></div>
@endsection
