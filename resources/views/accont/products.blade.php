@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Produtos cadastrados <a href="" class="btn btn-smallextreme btn-popmartin"><i class="fa fa-plus vertical-middle"></i> adicionar novo produto</a></h1>
        </header>

        <table id="pop-messages" class="table table-action">
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
            @for ($i = 0; $i < 5; $i++)
            <tr>
                <td><img src="{{ url('image/img-exemple.jpg') }}" alt="[]" title=""></td>
                <td>Produto X</td>
                <td>R$25,90</td>
                <td class="txt-center">5</td>
                <td class="t-draft txt-center">não</td>
                <td class="txt-center">
                    <a href="" class="t-btn t-edit">detalhe</a>
                    <a href="javscript:void(0)" class="t-btn t-remove">remover</a>
                </td>
            </tr>
            @endfor
            </tbody>
        </table>
        {{--<p><span class="btn btn-small btn-blue fl-right" style="font-size:1em;"><i class="fa fa-plus vertical-middle"></i> adicionar novo produto</span></p>--}}
    </section>
    <div class="txt-right">
        <a href="" class="btn btn-small btn-popmartin"><i class="fa fa-plus vertical-middle"></i> adicionar novo produto</a>
    </div>

    <div class="clear-both"></div>
@endsection
