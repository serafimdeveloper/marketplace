@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Minha loja</h1>
            <a href="" class="btn btn-smallextreme btn-popmartin" target="_blank">
                <i class="fa fa-external-link vertical-middle"></i>
                ver loja
            </a>
        </header>
        <form class="form-modern">
            <div class="colbox">
                <div class="colbox-2">
                    <label>
                        <span>Nome da loja</span>
                        {!! Form::text('name', null, ['placeholder' => 'Nome da Loja']) !!}
                        <span class="alert hidden"></span>
                    </label>
                    <div class="checkbox-container padding10">
                        <span>Tipo</span>
                        <div class="checkboxies">
                            <label class="radio select_type_sallesman" style="border: none;">
                                <span><span class="fa fa-circle-o"></span> física</span>
                                {!! Form::radio('type_sallesman', 'F') !!}
                            </label>
                            <label class="radio select_type_sallesman" style="border: none;">
                                <span><span class="fa fa-circle-o"></span> jurídica</span>
                                {!! Form::radio('type_sallesman', 'J') !!}
                            </label>
                        </div>
                        <span class="alert hidden"></span>
                    </div>
                    <div class="selects_people select_cpf">
                        <label>
                            <span>CPF</span>
                            {!! Form::text('cpf', null, ['class' => 'masked_cpf', 'placeholder' => 'CPF']) !!}
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                    <div class="selects_people select_cnpj">
                        <label>
                            <span>CNPJ</span>
                            {!! Form::text('cnpj', null, ['class' => 'masked_cnpj', 'placeholder' => 'CNPJ']) !!}
                            <span class="alert hidden"></span>
                        </label>
                        <label>
                            <span>Nome Fantasia</span>
                            {!! Form::text('fantasy_name', null, ['placeholder' => 'nome fantasia da Loja']) !!}
                            <span class="alert hidden"></span>
                        </label>
                        <label>
                            <span>Razão social</span>
                            {!! Form::text('social_name', null) !!}
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                </div>
                <div class="colbox-2">
                    <div class="txt-center">
                        <div id="preview_img1" class="prevImg"></div>
                        <div class="file" style="padding: 10px;">
                            {!! Form::file('logo_file', ['data-preview' => 1, 'onchange' => 'previewFile($(this))']) !!}
                            <input type="text">
                            <button type="button" class="btn btn-orange">Escolher Logo</button>
                            <div class="clear-both"></div>
                        </div>
                    </div>
                    <label>
                        <span>Sobre a Loja (máximo de 500 caracteres)</span>
                        <textarea name="content" placeholder="Digite aqui uma informação sobre a sua loja" rows="7"></textarea>
                    </label>
                    <label>
                        <span>Política de troca (máximo de 500 caracteres)</span>
                        <textarea name="content" placeholder="Digite aqui uma informação sobre a sua loja" rows="7"></textarea>
                    </label>
                </div>
            </div>
            <div class="clear-both"></div>
            <div class="txt-center" style="border-top: 1px solid #B0BEC5;padding-top: 10px;">
                <button type="submit" class="btn btn-popmartin">cadastrar</button>
            </div>
        </form>
        <div id="group-pnl-end">
                <div class="panel-end">
                    <h4>Endereço</h4>
                    <div class="panel-end-content">
                        <p>CEP: 27163000</p>
                        <p>rua 5, 126 - Califórnia da Barra</p>
                    </div>
                    <a href="javascript:void(0)" class="panel-end-edit vertical-flex jq-address" data-id="">editar|excluir</a>
                </div>
                <p class="trigger warning txt-center"><i class="fa fa-exclamation-circle"></i> Essa loja ainda não possui um endereço cadastrado</p>
        </div>
    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_adress')
@endsection