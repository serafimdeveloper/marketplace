@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Categorias cadastrada no sistema
                <a href="javascript:void(0)" class="btn btn-smallextreme btn-popmartin fl-right jq-new-category"> cadastrar nova categoria</a>
            </h1>
        </header>
        <table class="table table-action">
            <thead>
            <tr>
                <th class="t-medium">Nome</th>
                <th class="t-medium">categoria PAI</th>
                <th class="t-medium">url</th>
                <th class="t-medium txt-center">Principal</th>
                <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
            </tr>
            </thead>
            <tbody>
            @for ($i = 0; $i < 5; $i++)
                <tr id="category_01">
                    <td>Nome da categoria</td>
                    <td>nome categoria pai</td>
                    <td>nome-da-categoria</td>
                    <td class="txt-center">
                        <div class="form-modern">
                            <div class="checkbox-container">
                                <div class="checkboxies">
                                    <label class="checkbox" style="border: none;padding: 0;">
                                        <span><span class="fa fa-square-o"></span></span>
                                        {!! Form::checkbox('status','0') !!}
                                    </label>
                                </div>
                                <span class="alert{{ $errors->has('genre') ? '' : ' hidden' }}">{{ $errors->first('genre') }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="txt-center">
                        <a href="javascript:void(0)" class="t-btn t-edit jq-new-category" data-category="1">editar</a>
                        <a href="javascript:void(0)" class="t-btn t-remove">remover</a>
                    </td>
                </tr>
            @endfor
            </tbody>
        </table>
    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_newcategory')
@endsection
