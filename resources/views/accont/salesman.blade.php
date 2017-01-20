@extends('layouts.app')

@section('content')
    @include('accont.inc.nav')
    <section class="panel-content">
        <h2>Minhas informações de Vendedor</h2>
        <div class="colbox">
            <div class="colbox-2">
                <form class="form-modern pop-form" action="" method="POST">
                    <label>
                        <span class="title">CPF</span>
                        <input type="text" name="cpf" class="masked_cpf" placeholder="CPF">
                    </label>
                    <label>
                        <span class="title">Telefone fixo</span>
                        <input type="text" name="phone" class="masked_phone">
                    </label>
                    <label>
                        <span class="title">Telefone celular</span>
                        <input type="text" name="cellphone" class="masked_cellphone">
                    </label>
                    <label>
                        <span class="title">Whatsapp</span>
                        <input type="text" name="cellphone" class="masked_cellphone">
                    </label>
                    <br>
                    <div class="txt-center">
                        <button type="submit" class="btn btn-teal">atualizar</button>
                    </div>
                </form>
                <div class="form-modern">
                    <br>
                    <p class="c-pop fontw-500">Envio de documentos</p>
                    <p>
                        Para que seja autorizado o uso do Pop Martim como vendedor, você precisa
                        enviar uma cópia digitalizável e legível de um documento seu com foto(RG, CNH)
                        e de um comprovante de residência que esteja em seu nome.
                    </p>

                    <div class="txt-center">
                        <p>Documento com foto</p>
                        <div class="file" style="border:1px solid #B0BEC5;padding: 10px;">
                            <input type="file" name="an_logo" multiple="multiple" data-preview="1"
                                   onchange="previewFile($(this))">
                            <input type="text">
                            <button type="button" class="btn btn-orange">imagem</button>
                            <div class="clear-both"></div>
                        </div>
                        <br>
                        <p>Comprovante de residência</p>
                        <div class="file" style="border:1px solid #B0BEC5;padding: 10px;">
                            <input type="file" name="an_logo" multiple="multiple" data-preview="1"
                                   onchange="previewFile($(this))">
                            <input type="text">
                            <button type="button" class="btn btn-orange">imagem</button>
                            <div class="clear-both"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="colbox-2">
                {{--<h2>Dados MoIP</h2>--}}
                <h4 class="c-pop padding05">O que é MoIP?</h4>
                <p>
                    O MoIP é uma empresa de pagamentos online que possibilita o envio e recebimento
                    de dinheiro via internet. Através da sua conta no MoIP você receberá pelas suas
                    vendas no Pop Martin e consequentemente aceitará compras feitas com cartão de
                    crédito, cartão de débito, boleto e débito online. Sem uma conta de vendedor no
                    MoIP não é possível ativar a sua loja e vender no Pop Martin.</p>
                <a href="" class="btn btn-small btn-popmartin" target="_blank">Saiba mais</a>
                <div class="padding10"></div>
                <h4 class="c-pop padding05">Já me cadastrei no Moip</h4>
                <p>
                    Após concluir o seu cadastro, preencha o campo abaixo com o login fornecido pelo MOIP
                </p>
                <form class="form-modern pop-form" action="" method="POST">
                    <label>
                        <span class="title title-gray">login MOIP</span>
                        <input type="text" name="moip" placeholder="meulogin">
                    </label>
                </form>
                <div class="padding10"></div>
                <h4 class="c-pop padding05">Ainda não me cadastrei no MOIP</h4>
                <p>
                    Cadastre-se como vendedor no MoIP e comece a vender no Pop Martin aceitando
                    cartões de crédito, débito, boleto e débito online. O cadastro demora alguns
                    minutos e requer apenas informações simples como nome, endereço, e-mail, RG e CPF.
                </p>
                <a href="https://cadastro.moip.com.br/" class="btn btn-small btn-popmartin" target="_blank">cadastrar no
                    MOIP</a>
            </div>
        </div>
    </section>
    <div class="clear-both"></div>
    @include('layouts.parties.alert_adress')
@endsection