@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Minhas vendas</h1>
        </header>
        <table class="table table-action">
            <thead>
            <tr>
                <th class="t-small">Pedido</th>
                <th class="t-medium">Data</th>
                <th class="t-small">Valor</th>
                <th class="t-medium">Cliente</th>
                <th class="t-small">Status</th>
                <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
            </tr>
            </thead>

            <tbody>
            @forelse($requests as $request)
                <tr>
                    <td>#{{$request->key}}</td>
                    <td>{{$request->created_at->diffForHumans()}}</td>
                    <td>R${{number_format($request->amount,'2',',','.')}}</td>
                    <td>{{$request->user->name}}</td>
                    <td class="t-status t-{{ $request->requeststatus->trigger }}">{{ $request->requeststatus->description }}</td>
                    <td class="txt-center"><a href="/accont/salesman/sale/1" class="t-popmartin">detalhes</a></td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
        {!! $requests->links() !!}

    </section>
    <div class="clear-both"></div>
@endsection
