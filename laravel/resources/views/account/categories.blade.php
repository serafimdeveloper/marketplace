@extends('layouts.app')

@section('content')
    @include('account.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Categorias cadastrada no sistema</h1>
            <div class="pop-tile-menu">
                <a href="javascript:void(0)" class="alertbox-open btn btn-small btn-popmartin fl-right" data-alertbox="alert-newcategory"> cadastrar nova categoria</a>
            </div>
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
             @forelse($categories as $category)
                <tr id="category_01">
                    <td>{{$category->name}}</td>
                    <td>{{($category->category_id) ? $category->category->name : ''}}</td>
                    <td>{{$category->slug}}</td>
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
                        <a href="javascript:void(0)" class="alertbox-open t-btn t-edit jq-info" data-alertbox="alert-newcategory" data-category="{{$category->id}}">editar</a>
                        <a href="javascript:void(0)" class="t-btn t-remove" data-category="{{$category->id}}">remover</a>
                    </td>
                </tr>
            @empty
                 <tr>
                     <td colspan="4">Nenhuma Categoria Cadastrada</td>
                 </tr>
            @endforelse
            </tbody>
        </table>
        {!! $categories->links() !!}
    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_newcategory')
@endsection
