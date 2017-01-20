@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <h2>Produtos cadastrados <span class="btn btn-small btn-blue"style="font-size: 0.7em;"><i class="fa fa-plus vertical-middle"></i> adicionar novo produto</span></h2>
        <table id="pop-messages" class="table table-action">
            <thead>
            <tr>
                <th class="t-medium">Imagem</th>
                <th>Nome</th>
                <th class="t-medium">Preço</th>
                <th class="t-small">Estoque</th>
                <th class="t-small">Visível</th>
                <th class="t-small"></th>
                <th class="t-small"></th>

            </tr>
            </thead>

            <tbody>
            <tr>
                <td><img src="" alt="[]" title=""></td>
                <td>Produto X</td>
                <td>R$25,90</td>
                <td class="txt-center">5</td>
                <td class="t-draft txt-center">não</td>
                <td class="txt-center"><a href="" class="btn btn-teal">editar</a></td>
                <td class="txt-center"><a href="javscript:void(0)" class="btn btn-red">excluir</a></td>
            </tr>
            <tr>
                <td><img src="" alt="[]" title=""></td>
                <td>Produto X</td>
                <td>R$25,90</td>
                <td class="txt-center">5</td>
                <td class="t-active txt-center">sim</td>
                <td class="txt-center"><a href="" class="btn btn-teal">editar</a></td>
                <td class="txt-center"><a href="javscript:void(0)" class="btn btn-red">excluir</a></td>
            </tr>
            </tbody>
        </table>
        {{--<p><span class="btn btn-small btn-blue fl-right" style="font-size:1em;"><i class="fa fa-plus vertical-middle"></i> adicionar novo produto</span></p>--}}
    </section>
    <div class="clear-both"></div>
@endsection
