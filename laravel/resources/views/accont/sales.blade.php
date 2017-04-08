@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Minhas vendas</h1>
            <div class="pop-tile-menu">
                <div class="form-modern">
                    {!! Form::model($request_status, ['class' => 'orderTable', 'route' => 'accont.salesman.sales', 'method' => 'get']) !!}
                    {!! Form::select('status', $request_status, (isset($selected_status) ? $selected_status : null), ['placeholder' => 'todos']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </header>
        @if(!$requests->first())
            <p class="trigger notice fontem-14">Nenhuma venda foi registrada até o momento!</p>
        @else
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
                        <tr {!! !$request->visualized_store ? 'class="t-unread"' : '' !!}>
                        <td>#{{$request->key}}</td>
                        <td>{{$request->created_at->diffForHumans()}}</td>
                        <td>{{real($request->amount)}}</td>
                        <td>{{$request->user->name}}</td>
                        <td class="t-status t-{{ $request->requeststatus->trigger }}">{{ $request->requeststatus->description }}</td>
                        <td class="txt-center"><a href="{{route('accont.salesman.sale_info',$request->id)}}"
                                                  class="t-popmartin">detalhes</a></td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        @endif
        <div class="fl-right">{!! $requests->links() !!}</div>
        <div class="clear-both"></div>
    </section>
    <div class="clear-both"></div>
@endsection
