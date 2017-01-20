@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <div class="colbox">
            <div class="colbox-2">
                <h2>Dados do Usuários</h2>
                  {!!Form::model($user,['route'=>['account.home.store'],'method'=>'POST','class'=>'form-modern pop-form'])!!}
                    <label>
                        <span class="title">Nome</span>
                        {!! Form::text('name',null, ['placeholder' => 'Seu nome']) !!}
                        <span class="alert{{ $errors->has('name') ? '' : ' hidden' }}">{{ $errors->first('name') }}</span>
                    </label>
                    <label>
                        <span class="title">Apelido</span>
                         {!! Form::text('nick',null, ['placeholder' => 'Apelido']) !!}
                       <span class="alert{{ $errors->has('nick') ? '' : ' hidden' }}">{{ $errors->first('nick') }}</span>
                    </label>
                    <label>
                        <span class="title">Cpf</span>
                        {!! Form::text('document',null, ['class'=>'masked_cpf','placeholder' => 'Meu CPF']) !!}
                       <span class="alert{{ $errors->has('cpf') ? '' : ' hidden' }}">{{ $errors->first('cpf') }}</span>
                    </label>
                    <label>
                        <span class="title">Data de Nascimento</span>                       
                        {!! Form::date('birth',null, ['placeholder' => 'data de nascimento']) !!}
                        <span class="alert{{ $errors->has('birth') ? '' : ' hidden' }}">{{ $errors->first('birth') }}</span>
                    </label>
                    <div class="checkbox-container padding10">
                        <span class="title">Gênero</span>
                        <div class="checkboxies">
                            <label class="radio">
                                <span><span class="fa {{ ($user->genre === 'M') ? 'fa-check-circle-o c-green':'fa-circle-o'}}"></span> masculino</span>
                                {!! Form::radio('genre','M') !!}
                            </label>
                            <label class="radio">
                                <span><span class="fa {{ ($user->genre === 'F') ? 'fa-check-circle-o c-green':'fa-circle-o'}}"></span> feminino</span>
                                {!! Form::radio('genre','F') !!}
                            </label>
                        </div>
                        <span class="alert{{ $errors->has('genre') ? '' : ' hidden' }}">{{ $errors->first('genre') }}</span>
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
                <div id="group-pnl-end">
                @forelse($user->adresses as $adress)
                    <div class="panel-end">
                        <h4>Nome do endereço <span class="fl-right">principal</span></h4>
                        <div class="panel-end-content">
                            <p>CEP: {{$adress->zip_code}}</p>
                            <p>{{$adress->public_place}}, {{$adress->number}} - {{$adress->city}}</p>
                        </div>
                        <a href="javascript:void(0)" class="panel-end-edit vertical-flex jq-address" data-id="{{$adress->id}}">editar</a>
                    </div>
                @empty
                    <h3>Não tem endereços</h3>
                @endforelse
                </div>
            </div>
        </div>
        <br>
        <hr>
        <div class="content">
            <h2 style="text-align: center;">Dados do conta</h2>

            {!! Form::open(['route' => ['changepassword.store'], 'method' => 'POST','class'=>'content form-modern pop-form']) !!}
                <label>
                    <span class="title title-gray">email</span>
                    <input type="text" name="email" value="{{$user->email}}" disabled="true" style="color: #FFFFFF;background-color: #888888;">
                </label>
                <label>
                    <span>senha atual</span>
                    {!! Form::password('password',null, [ 'placeholder' => 'Senha']) !!}                  
                    <span class="alert{{ $errors->has('password') ? '' : ' hidden' }}">{{ $errors->first('password') }}</span>
                </label>
                <label>
                    <span>criar nova senha</span>
                    {!! Form::password('newpassword',null, [ 'placeholder' => 'Nova senha']) !!}
                    <span class="alert{{ $errors->has('newpassword') ? '' : ' hidden' }}">{{ $errors->first('newpassword') }}</span>
                </label>
                <label>
                    <span>repetir senha</span>
                    {!! Form::password('newpassword_confirmation',null, [ 'placeholder' => 'Repita sua nova senha']) !!}
                    <span class="alert{{ $errors->has('newpassword_confirmation') ? '' : ' hidden' }}">{{ $errors->first('newpassword_confirmation') }}</span>
                </label>
                <div class="txt-center">
                    <button type="submit" class="btn btn-teal">atualizar senha</button>
                </div>
             {!!Form::close()!!}
        </div>
    </section>
    @include('layouts.parties.alert_adress')
    <div class="clear-both"></div>
@endsection
