@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <div class="colbox">
            <div class="colbox-2">
                <h2>Loja</h2>
                <form class="form-modern pop-form">
                    <label>
                        <span class="title">Nome da loja</span>
                        <input type="text" name="name" value="Casas Bahia">
                        <span class="alert hidden"></span>
                    </label>
                    <div class="checkbox-container padding10">
                        <span class="title">Tipo</span>
                        <div class="checkboxies">
                            <label class="radio select_type_sallesman">
                                <span><span class="fa fa-circle-o"></span> física</span>
                                <input type="radio" name="type_sallesman" value="F">
                            </label>
                            <label class="radio select_type_sallesman">
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
                    <div class="txt-center">
                        <div class="file" style="border:1px solid #B0BEC5;padding: 10px;">
                            <input type="file" name="an_logo" multiple="multiple" data-preview="1"
                                   onchange="previewFile($(this))">
                            <input type="text">
                            <button type="button" class="btn btn-orange">Escolher Logo</button>
                            <div class="clear-both"></div>
                        </div>
                        <br>
                        <div class="prevImg"></div>
                        <div class="txt-center" style="border-top: 1px solid #B0BEC5;padding-top: 10px;">
                            <button type="submit" class="btn btn-teal">cadastrar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="colbox-2">
                <h2>Endereço <span class="btn btn-smallextreme btn-blue fl-right jq-address" style="font-size: 0.7em;"><i class="fa fa-plus vertical-middle"></i> novo</span></h2>

            </div>
        </div>
    </section>
    <div class="clear-both"></div>
    @include('accont.inc.lightboxaddress')
@endsection