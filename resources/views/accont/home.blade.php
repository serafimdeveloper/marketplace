@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <div class="colbox">
            <div class="colbox-2">
                <h2>Dados do usuários</h2>

                <form class="form-modern pop-form">
                    <label>
                        <span class="title">nome</span>
                        <input type="text" name="name" value="Meu nome">
                    </label>
                    <label>
                        <span class="title">sobrenome</span>
                        <input type="text" name="name" value="Meu sobrenome">
                    </label>
                    <label>
                        <span class="title">cpf</span>
                        <input type="text" name="name" value="Meu cpf">
                    </label>
                    <label>
                        <span class="title">data de nascimento</span>
                        <input type="date" name="name" value="data de nascimento">
                    </label>
                    <div class="checkbox-container padding10">
                        <span class="title">Gênero</span>
                        <div class="checkboxies">
                            <label class="radio">
                                <span><span class="fa fa-circle-o"></span> masculino</span>
                                <input type="radio" name="gener" value="M">
                            </label>
                            <label class="radio">
                                <span><span class="fa fa-circle-o"></span> feminino</span>
                                <input type="radio" name="gener" value="F">
                            </label>
                        </div>
                    </div>
                    <div class="txt-center" style="border-top: 1px solid #B0BEC5;padding-top: 10px;">
                        <button type="submit" class="btn btn-teal">atualizar dados</button>
                    </div>
                </form>
            </div>
            <div class="colbox-2">
                <h2>Endereços</h2>
                <div class="panel-end">
                    <h4>Nome do endereço <span class="fl-right">principal</span></h4>
                    <div class="panel-end-content">
                        <p>CEP: 27286210</p>
                        <p>Rua Dom Anônio Cabral, 123 - Rio de janeiro</p>
                    </div>
                    <a href="javascript:void(0)" class="panel-end-edit vertical-flex" data-id="1">editar</a>
                </div>
                <div class="panel-end">
                    <h4>Nome do endereço</h4>
                    <div class="panel-end-content">
                        <p>CEP: 27286210</p>
                        <p>Rua Dom Anônio Cabral, 123 - Rio de janeiro</p>
                    </div>
                    <a href="javascript:void(0)" class="panel-end-edit vertical-flex" data-id="2">editar</a>
                </div>

                <h2>Dados do conta</h2>

                <form class="form-modern pop-form">
                    <label>
                        <span class="title title-gray">criar nova senha</span>
                        <input type="password" name="password" placeholder="senha">
                    </label>
                    <label>
                        <span class="title title-gray">repetir senha</span>
                        <input type="password" name="password2" placeholder="senha">
                    </label>
                    <div class="txt-center">
                        <button type="submit" class="btn btn-teal">atualizar senha</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <div class="alertbox adress">
        <div class="alertbox-container">
            <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
            <div class="alertbox-content">
                <h2 class="alertbox-title">Editar endereço</h2>
                <form class="form-modern">
                    <label>
                        <span>CEP:</span>
                        <input type="text" name="cep" value="27286210">
                    </label>
                    <label>
                        <span>CEP:</span>
                        <input type="text" name="cep" value="27286210">
                    </label>
                </form>
            </div>
        </div>
    </div>
    <div class="clear-both"></div>
@endsection
