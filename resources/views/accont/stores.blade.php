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
                        <input type="text" name="name" value="Casas Bahia">
                        <span class="alert hidden"></span>
                    </label>
                    <div class="checkbox-container padding10">
                        <span>Tipo</span>
                        <div class="checkboxies">
                            <label class="radio select_type_sallesman" style="border: none;">
                                <span><span class="fa fa-circle-o"></span> física</span>
                                <input type="radio" name="type_sallesman" value="F">
                            </label>
                            <label class="radio select_type_sallesman" style="border: none;">
                                <span><span class="fa fa-circle-o"></span> jurídica</span>
                                <input type="radio" name="type_sallesman" value="J">
                            </label>
                        </div>
                        <span class="alert hidden"></span>
                    </div>
                    <div class="selects_people select_cpf">
                        <label>
                            <span>CPF</span>
                            <input type="text" name="cnpj" class="masked_cpf" placeholder="CPF">
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                    <div class="selects_people select_cnpj">
                        <label>
                            <span>CNPJ</span>
                            <input type="text" name="cnpj" class="masked_cnpj" placeholder="CNPJ">
                            <span class="alert hidden"></span>
                        </label>
                        <label>
                            <span>Nome Fantasia</span>
                            <input type="text" name="fantasy_name">
                            <span class="alert hidden"></span>
                        </label>
                        <label>
                            <span>Razão social</span>
                            <input type="text" name="social_name">
                            <span class="alert hidden"></span>
                        </label>
                    </div>
                </div>
                <div class="colbox-2">
                    <div class="txt-center">
                        <div class="prevImg"></div>
                        <div class="file" style="padding: 10px;">
                            <input type="file" name="an_logo" multiple="multiple" data-preview="1"
                                   onchange="previewFile($(this))">
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
    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_adress')
@endsection