@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <div class="colbox">
            <div class="colbox-2">
                <h2>Dados do usuários</h2>
                  {!!Form::model($user,['route'=>['account.home.store'],'method'=>'POST','class'=>'form-modern pop-form'])!!}
                    <label>
                        <span class="title">nome</span>
                        {!! Form::text('name',null, ['placeholder' => 'Seu nome']) !!}
                        <span class="alert hidden"></span>
                    </label>
                    <label>
                        <span class="title">apelido</span>
                         {!! Form::text('nick',null, ['placeholder' => 'Apelido']) !!}
                        <span class="alert hidden"></span>
                    </label>
                    <label>
                        <span class="title">cpf</span>
                        {!! Form::text('document',null, ['class'=>'masked_cpf','placeholder' => 'Meu CPF']) !!}
                        <span class="alert hidden"></span>
                    </label>
                    <label>
                        <span class="title">data de nascimento</span>                       
                        {!! Form::date('birth',null, ['placeholder' => 'data de nascimento']) !!}
                        <span class="alert hidden"></span>
                    </label>
                    <div class="checkbox-container padding10">
                        <span class="title">Gênero</span>
                        <div class="checkboxies">
                            <label class="radio">
                                <span><span class="fa fa-circle-o"></span> masculino</span>
                                {!! Form::radio('genre','M') !!}
                            </label>
                            <label class="radio">
                                <span><span class="fa fa-circle-o"></span> feminino</span>
                                {!! Form::radio('genre','F') !!}
                            </label>
                        </div>
                        <span class="alert hidden"></span>
                    </div>
                    <div class="txt-center" style="border-top: 1px solid #B0BEC5;padding-top: 10px;">
                        <button type="submit" class="btn btn-teal">atualizar dados</button>
                    </div>
                {!!Form::close()!!}
            </div>
            <div class="colbox-2">
                <h2>Endereços <span class="btn btn-smallextreme btn-blue fl-right jq-address"
                                    style="font-size: 0.7em;"><i class="fa fa-plus vertical-middle"></i> novo</span>
                </h2>
                <div class="panel-end">
                    <h4>Nome do endereço <span class="fl-right">principal</span></h4>
                    <div class="panel-end-content">
                        <p>CEP: 27286210</p>
                        <p>Rua Dom Anônio Cabral, 123 - Rio de janeiro</p>
                    </div>
                    <a href="javascript:void(0)" class="panel-end-edit vertical-flex jq-address" data-id="1">editar</a>
                </div>
                <div class="panel-end">
                    <h4>Nome do endereço</h4>
                    <div class="panel-end-content">
                        <p>CEP: 27286210</p>
                        <p>Rua Dom Anônio Cabral, 123 - Rio de janeiro</p>
                    </div>
                    <a href="javascript:void(0)" class="panel-end-edit vertical-flex jq-address" data-id="2">editar</a>
                </div>
            </div>
        </div>
        <br>
        <hr>
        <div class="content">
            <h2 style="text-align: center;">Dados do conta</h2>

            <form class="content form-modern pop-form">
                <label>
                    <span class="title title-gray">email</span>
                    <input type="text" name="email" value="contato@brunosite.com" disabled="true" style="color: #FFFFFF;background-color: #888888;">
                </label>
                <label>
                    <span>senha atual</span>
                    <input type="password" name="password" placeholder="senha">
                </label>
                <label>
                    <span>criar nova senha</span>
                    <input type="password" name="newpassword" placeholder="senha">
                </label>
                <label>
                    <span>repetir senha</span>
                    <input type="password" name="newpassword_repeat" placeholder="senha">
                </label>
                <div class="txt-center">
                    <button type="submit" class="btn btn-teal">atualizar senha</button>
                </div>
            </form>
        </div>
    </section>
    <div class="alertbox address">
        <div class="alertbox-container">
            <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
            <div class="alertbox-content">
                <h2 class="alertbox-title">Cadastrar novo endereço</h2>
                <form class="form-modern pop-form">
                    <label>
                        <span>CEP:</span>
                        <input type="text" name="cep" value="27286210">
                    </label>
                    <div class="colbox">
                        <div class="colbox-2">
                            <label>
                                <span class="title">UF:</span>
                                <input type="text" name="uf" value="27286210">
                            </label>
                        </div>
                        <div class="colbox-2">
                            <label>
                                <span class="title">Município:</span>
                                <input type="text" name="citie" value="27286210">
                            </label>
                        </div>
                    </div>
                    <div class="clear-both"></div>
                    <label>
                        <span>Bairro:</span>
                        <input type="text" name="neighborhood" value="27286210">
                    </label>
                    <label>
                        <span>endereço:</span>
                        <input type="text" name="logradouro" value="27286210">
                    </label>
                    <div class="colbox">
                        <div class="colbox-2">
                            <label>
                                <span>Número:</span>
                                <input type="text" name="number" value="27286210">
                            </label>
                        </div>
                        <div class="colbox-2">
                            <label>
                                <span>Complemento:</span>
                                <input type="text" name="complements" value="27286210">
                            </label>
                        </div>
                    </div>
                    <div class="clear-both"></div>
                    <div class="txt-center">
                        <button type="submit" class="btn btn-teal">cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="clear-both"></div>
@endsection
