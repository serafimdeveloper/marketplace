@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <div class="colbox">
            <article class="colbox-2">
                <header class="pop-title">
                    <h1>Dados do Usuários</h1>
                </header>
                  {!!Form::model($user,['route'=>['account.home.store'],'method'=>'POST','class'=>'form-modern pop-form'])!!}
                    <label>
                        <span>Nome</span>
                        {!! Form::text('name',null, ['placeholder' => 'Seu nome']) !!}
                        <span class="alert{{ $errors->has('name') ? '' : ' hidden' }}">{{ $errors->first('name') }}</span>
                    </label>
                    <label>
                        <span>Sobrenome</span>
                        {!! Form::text('last_name',null, ['placeholder' => 'Sobrenome']) !!}
                        <span class="alert{{ $errors->has('last_name') ? '' : ' hidden' }}">{{ $errors->first('last_name') }}</span>
                    </label>
                    <label>
                        <span>Cpf</span>
                        {!! Form::text('cpf',null, ['class'=>'masked_cpf','placeholder' => 'Meu CPF']) !!}
                       <span class="alert{{ $errors->has('cpf') ? '' : ' hidden' }}">{{ $errors->first('cpf') }}</span>
                    </label>
                    <label>
                        <span>Data de Nascimento</span>
                        {!! Form::date('birth',null, ['placeholder' => 'data de nascimento']) !!}
                        <span class="alert{{ $errors->has('birth') ? '' : ' hidden' }}">{{ $errors->first('birth') }}</span>
                    </label>
                    <div class="checkbox-container padding10">
                        <span>Gênero</span>
                        <div class="checkboxies">
                            <label class="radio" style="border: none;">
                                <span><span class="fa {{ ($user->genre === 'M') ? 'fa-check-circle-o c-green':'fa-circle-o'}}"></span> masculino</span>
                                {!! Form::radio('genre','M') !!}
                            </label>
                            <label class="radio" style="border: none;">
                                <span><span class="fa {{ ($user->genre === 'F') ? 'fa-check-circle-o c-green':'fa-circle-o'}}"></span> feminino</span>
                                {!! Form::radio('genre','F') !!}
                            </label>
                        </div>
                        <span class="alert{{ $errors->has('genre') ? '' : ' hidden' }}">{{ $errors->first('genre') }}</span>
                    </div>
                <label>
                    <span>Telefone</span>
                    {!! Form::text('phone',null, ['placeholder' => 'Informar telefone', 'class' => 'masked_cellphone']) !!}
                    <span class="alert{{ $errors->has('phone') ? '' : ' hidden' }}">{{ $errors->first('phone') }}</span>
                </label>
                    <div class="txt-center" style="border-top: 1px solid #B0BEC5;padding-top: 10px;">
                        <button type="submit" class="btn btn-popmartin">atualizar dados</button>
                    </div>
                {!!Form::close()!!}
            </article>
            <div class="colbox-2">
                <header class="pop-title">
                    <h1>Endereços</h1>
                    <span class="btn btn-smallextreme btn-popmartin jq-address"><i class="fa fa-plus vertical-middle"></i> novo</span>
                </header>
                <div id="group-pnl-end">
                @forelse($adresses as $adress)
                    <div class="panel-end" id="end_{{$adress->id}}">
                        <h4>{{$adress->name}} <span class="fl-right address-master">{!! $adress->master ? 'principal' : '' !!}</span></h4>
                        <div class="panel-end-content">
                            <p>CEP: {{$adress->zip_code}}</p>
                            <p>{{$adress->public_place}}, {{$adress->number}} - {{$adress->city}}</p>
                        </div>
                        <a href="javascript:void(0)" class="panel-end-edit vertical-flex jq-address" data-id="{{$adress->id}}">editar|excluir</a>
                    </div>
                @empty
                    <div id="isAddress">
                        <p class="trigger warning txt-center"><i class="fa fa-exclamation-circle"></i> Você ainda não possui endereços cadastrado</p>
                        <p class="txt-center"><a href="javascript:void(0)" class="btn btn-popmartin jq-address">cadastrar um endereço</a></p>
                    </div>
                @endforelse
                </div>
            </div>
        </div>
        <br>
        <hr>
        <div class="content">
            <h2 style="text-align: center;">Dados do conta</h2>

            {!! Form::open(['route' => ['changepassword.store'], 'method' => 'POST','class'=>'content form-modern']) !!}
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
                    <button type="submit" class="btn btn-popmartin">atualizar senha</button>
                </div>
             {!!Form::close()!!}
        </div>
    </section>
    @include('layouts.parties.alert_adress')
    <div class="clear-both"></div>
@endsection
