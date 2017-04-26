@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Produtos cadastrados</h1>
            <div class="pop-tile-menu">
                <a href="{{route('accont.salesman.products.create')}}" class="btn btn-smallextreme btn-popmartin"><i
                            class="fa fa-plus vertical-middle"></i> adicionar novo produto</a>
            </div>
        </header>
        @if(!$products->first())
            <p class="trigger notice fontem-14">Não há produto cadastrado <br>
                <a href="{{route('accont.salesman.products.create')}}" class="btn btn-smallextreme btn-popmartin">Cadastrar meu primeiro produto</a>
            </p>
        @else
            <table id="pop-messages" class="table table-action fontem-12">
                <thead>
                <tr>
                    <th class="t-medium" style="width: 60px;">Imagem</th>
                    <th>Nome</th>
                    <th class="t-medium">Preço</th>
                    <th class="t-small">Estoque</th>
                    <th class="t-small">Visível</th>
                    <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
                </tr>
                </thead>

                <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td><img src="{{ ($product->galeries->first() ? url('imagem/produto/'.$product->galeries->first()->image.'?w=42&h=42') : url('/imagem/popmartin/img-exemple.jpg?w=42&h=42')) }}"
                                 alt="[]" title=""></td>
                        <td>{{$product->name}}</td>
                        <td class="text-capitalize">{{real($product->price)}}</td>
                        <td class="txt-center">{{$product->quantity}}</td>
                        <td class="t-draft txt-center">{{($product->active === 1) ? 'sim' : 'não'}}</td>
                        <td class="txt-center">
                            <a href="{{route('accont.salesman.products.edit',$product->id)}}" class="t-btn t-edit">detalhes</a>
                            <a href="javscript:void(0)" class="t-btn t-remove jq-remove-product" data-token="{{csrf_token()}}"
                               data-id="{{$product->id}}">remover</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Nenhum produto cadastrado</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="fl-right">{!! $products->render() !!}</div>
            <div class="clear-both"></div>
            <br>
            <br>
            <div class="txt-right">
                <a href="{{route('accont.salesman.products.create')}}" class="btn btn-small btn-popmartin">
                    <i class="fa fa-plus vertical-middle"></i> adicionar novo produto
                </a>
            </div>
        @endif
    </section>

    <br>
    <div class="clear-both"></div>
@endsection
