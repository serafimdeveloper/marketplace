@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <header class="pop-title">
            <h1>Minhas informações de Vendedor</h1>
        </header>
        <form class="form-modern" action="" method="POST">
            <div class="colbox">
                <div class="colbox-2">
                    <label>
                        <span>CPF</span>
                        {!! Form::text('cpf', null, ['class' => 'masked_cpf', 'placeholder' => 'CPF']) !!}
                    </label>
                    <label>
                        <span>Telefone fixo</span>
                        {!! Form::text('phone', null, ['class' => 'masked_phone']) !!}
                    </label>
                    <label>
                        <span>Telefone celular</span>
                        {!! Form::text('cellphone', null, ['class' => 'masked_cellphone']) !!}
                    </label>
                    <label>
                        <span>Whatsapp</span>
                        {!! Form::text('whatsapp', null, ['class' => 'masked_cellphone']) !!}
                    </label>
                    <br>
                    <div class="form-modern">
                        <br>
                        <p class="c-pop fontw-800">Envio de documentos</p>
                        <p>
                            Para que seja autorizado o uso do Pop Martin como vendedor, você precisa
                            enviar uma cópia digitalizável e legível de um documento seu com foto(RG, CNH)
                            e de um comprovante de residência que esteja em seu nome.
                        </p>

                        <div class="txt-center">
                            <p>Documento com foto (formato PNG ou JPG)</p>
                            <div class="file" style="border:1px solid #B0BEC5;padding: 10px;">
                                {!! Form::file('photo_document') !!}
                                <input type="text">
                                <button type="button" class="btn btn-orange">imagem</button>
                                <div class="clear-both"></div>
                            </div>
                            <br>
                            <p>Comprovante de residência (formato PNG ou JPG ou PDF)</p>
                            <div class="file" style="border:1px solid #B0BEC5;padding: 10px;">
                                {!! Form::file('proof_adress') !!}
                                <input type="text">
                                <button type="button" class="btn btn-orange">imagem</button>
                                <div class="clear-both"></div>
                            </div>
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
                    <a href="" class="btn btn-small btn-popmartin" target="_blank">Saiba mais</a>
                    <div class="padding10"></div>
                    <p class="c-pop padding05 fontw-800">Já me cadastrei no Moip</p>
                    <p>
                        Após concluir o seu cadastro, preencha o campo abaixo com o login fornecido pelo MOIP
                    </p>
                    <label>
                        <span>login MOIP</span>
                        {!! Form::text('moip', null, ['placeholder' => 'meulogin']) !!}
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
                <button type="submit" class="btn btn-popmartin">atualizar</button>
            </div>
        </form>
    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_adress')
@endsection