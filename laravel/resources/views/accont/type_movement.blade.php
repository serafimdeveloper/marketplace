@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Categorias cadastrada no sistema
                <a href="javascript:void(0)" class="btn btn-smallextreme btn-popmartin fl-right jq-new-typemovementsstock"> cadastrar nova categoria</a>
            </h1>
        </header>
        <table class="table table-action">
            <thead>
            <tr>
                <th class="t-medium">Nome</th>
                <th class="t-medium">Descrição</th>
                <th class="t-medium">Tipo</th>
                <th class="t-medium txt-center">Ativo</th>
                <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
            </tr>
            </thead>
            <tbody>
             @forelse($typemovementsstocks as $typemovementsstock)
                <tr id="typemovementsstock_01">
                    <td>{{$typemovementsstock->name}}</td>
                    <td>{{$typemovementsstock->description}}</td>
                    <td>{{$typemovementsstock->slug}}</td>
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
                        <a href="javascript:void(0)" class="t-btn t-edit jq-new-typemovementsstock" data-typemovementsstock="{{$typemovementsstock->id}}">editar</a>
                        <a href="javascript:void(0)" class="t-btn t-remove" data-typemovementsstock="{{$typemovementsstock->id}}">remover</a>
                    </td>
                </tr>
            @empty
                 <tr>
                     <td colspan="4">Nenhuma Categoria Cadastrada</td>
                 </tr>
            @endforelse
            </tbody>
        </table>
    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_newtypemovementsstock')
@endsection
