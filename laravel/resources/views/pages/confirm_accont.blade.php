@extends('layouts.app')

@section('content')
    <section class="content">
        <header class="pop-title">
            <h1>Confirmar sua Conta </h1>
        </header>
        <article>
            <p class="trigger warning"><i class="fa fa-warning"></i>
                ATENÇÃO: Para acessar seu painel é necessário que você confirme sua conta de email.
            </p>
            <p style="font-weight: bold; margin-top: 10px">Olá {{$user->name}}</p>
            <p>A confirmação de sua conta por email é uma forma de segurança, para lhe garantir que ninguém usará seu email!<br>
            Para isso é muito simples, basta acessar o email que você usou para se cadastrar, olhar a sua caixa de entrada,
            vê o nosso email é clicar no link informado! :)
            </p>
            <br>
            <p>Caso você não tenha recebido o email clique no botão abaixo</p>
            <div class="txt-center" style="border-top: 1px solid #B0BEC5;padding-top: 10px;">
                <a href="{{route('confirm.send_email')}}" class="btn btn-green ">Receber o email de confirmação</a>
            </div>
        </article>
    </section>
@endsection