@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Minhas informações de Vendedor</h1>
        </header>
        @if(isset($salesman))
            {!!Form::model($salesman,['url' => '/accont/salesman/update', 'method' => 'POST', 'class' => 'form-modern pop-form', 'enctype'=>'multipart/form-data'])!!}
        @else
            {!! Form::open(['route' => ['accont.salesman.store'], 'method' => 'POST', 'class' => 'form-modern pop-form', 'enctype'=>'multipart/form-data']) !!}
        @endif
        <div class="colbox">
            <div class="colbox-2">
                <label>
                    <span>CPF <sup class="c-red fontem-06 fl-right">obrigatório</sup></span>
                    {!! Form::text(null, Auth::user()->cpf, ['disable' => true]) !!}
                    <span class="alert{{ $errors->has('cpf') ? '' : ' hidden' }}">{{ $errors->first('cpf') }}</span>

                </label>
                <label>
                    <span>Telefone fixo <sup class="c-red fontem-06 fl-right">obrigatório</sup></span>
                    {!! Form::text('phone', null, ['class' => 'masked_phone', 'data-required' => 'fullphone']) !!}
                    <span class="alert{{ $errors->has('phone') ? '' : ' hidden' }}">{{ $errors->first('phone') }}</span>

                </label>
                <label>
                    <span>Telefone celular <sup class="c-red fontem-06 fl-right">obrigatório</sup></span>
                    {!! Form::text('cellphone', null, ['class' => 'masked_fullphone', 'data-required' => 'fullphone']) !!}
                    <span class="alert{{ $errors->has('cellphone') ? '' : ' hidden' }}">{{ $errors->first('cellphone') }}</span>

                </label>
                <label>
                    <span>Whatsapp</span>
                    {!! Form::text('whatsapp', null, ['class' => 'masked_fullphone', 'data-required' => 'whatsapp']) !!}
                    <span class="alert{{ $errors->has('whatsapp') ? '' : ' hidden' }}">{{ $errors->first('whatsapp') }}</span>

                </label>
                <br>

                <div class="form-modern">
                    <br>
                    <p class="c-pop fontw-800">Envio de documentos <sup class="c-red fontem-06 fl-right">obrigatório</sup></p>
                    @if(!isset($salesman->photo_document) || !isset($salesman->proof_adress))
                        <p>
                            Para que seja autorizado o uso do Pop Martin como vendedor, você precisa
                            enviar uma cópia digitalizada e legível de um documento seu com foto(RG, CNH)
                            e de um comprovante de residência que esteja em seu nome.
                        </p>
                    @endif


                    <div class="txt-center">
                        @if(!$isDocs['document'])
                            <p>Documento com foto (formato PNG ou JPG)</p>
                            <div class="file" style="border:1px solid #B0BEC5;padding: 10px;">
                                {!! Form::file('photo_document') !!}
                                <input type="text" value="{{ old('photo_document') }}">
                                <button type="button" class="btn btn-orange">imagem</button>
                                <div class="clear-both"></div>
                                <span class="alert{{ $errors->has('photo_document') ? '' : ' hidden' }}">{{ $errors->first('photo_document') }}</span>
                            </div>
                        @else
                            <p>
                                <img src="{{url('imagem/vendedor/'.$salesman->photo_document.'?w=180&h=120')}}"><br>
                                Documento com foto enviado
                            </p>
                        @endif
                        <br>
                        @if(!$isDocs['document'])
                            <p>Comprovante de residência (formato PNG ou JPG ou PDF)</p>
                            <div class="file" style="border:1px solid #B0BEC5;padding: 10px;">
                                {!! Form::file('proof_adress') !!}
                                <input type="text" value="{{ old('proof_adress') }}">
                                <button type="button" class="btn btn-orange">imagem</button>
                                <div class="clear-both"></div>
                                <span class="alert{{ $errors->has('proof_adress') ? '' : ' hidden' }}">{{ $errors->first('proof_adress') }}</span>
                            </div>
                        @else
                            <p>
                                @if(substr($salesman->proof_adress, -3) == 'pdf')
                                    {{--<a href="{{url('imagem/vendedor/'.$salesman->proof_adress)}}" target="_blank">ver comprovante</a><br>--}}
                                    <span class="fa fa-file-pdf-o fontem-20"></span><br>
                                @else
                                    <img src="{{url('imagem/vendedor/'.$salesman->proof_adress.'?w=180&h=120')}}"><br>
                                @endif
                                Comprovante de endereço enviado
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="colbox-2">
                {{--<h2>Dados MoIP</h2>--}}
                <p class="c-pop padding05 fontw-800">O que é MoIP?</p>
                <p>
                    O MoIP é uma empresa de pagamentos online que possibilita o envio e recebimento
                    de dinheiro via internet. Através da sua conta no MoIP você receberá pelas suas
                    vendas no Pop Martin e consequentemente aceitará compras feitas com cartão de
                    crédito, cartão de débito, boleto e débito online. Sem uma conta de vendedor no
                    MoIP não é possível ativar a sua loja e vender no Pop Martin.</p>
                <a href="https://moip.com.br/" class="btn btn-small btn-popmartin" target="_blank">Saiba mais</a>
                <div class="padding10"></div>
                <p class="c-pop padding05 fontw-800">Já me cadastrei no Moip</p>
                <p>
                    Após concluir o seu cadastro, preencha o campo abaixo com o login fornecido pelo MOIP
                </p>
                <label>
                    <span>login MOIP <sup class="c-red fontem-06 fl-right">obrigatório</sup></span>
                    {!! Form::text('moip', null, ['placeholder' => 'meulogin']) !!}
                    <span class="alert{{ $errors->has('moip') ? '' : ' hidden' }}">{{ $errors->first('moip') }}</span>

                </label>
                <div class="padding10"></div>
                <p class="c-pop padding05 fontw-800">Ainda não me cadastrei no MOIP</p>
                <p>
                    Cadastre-se como vendedor no MoIP e comece a vender no Pop Martin aceitando
                    cartões de crédito, débito, boleto e débito online. O cadastro demora alguns
                    minutos e requer apenas informações simples como nome, endereço, e-mail, RG e CPF.
                </p>
                <a href="https://cadastro.moip.com.br/" class="btn btn-small btn-popmartin" target="_blank">cadastrar
                    no
                    MOIP</a>
            </div>
        </div>
        <div class="txt-center">
            <button type="submit" class="btn btn-popmartin"
                    style="margin-top:15px">{{isset($salesman) ? 'atualizar' : 'gravar'}}</button>
        </div>
        {!! Form::close() !!}
    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_adress')
@endsection