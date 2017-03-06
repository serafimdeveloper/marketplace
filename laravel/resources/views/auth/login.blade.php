@extends('layouts.app')
@section('content')
<section class="pop-forms content">
    <div class="colbox">
        <article class="colbox-2">
            <header class="pop-title">
                <h1>Já sou usuário do Pop Martin</h1>
            </header>
            <div class="txt-center">
                <a class="modal modal-blueface" href="">
                    <span><i class="fa fa-facebook-f"></i> | conecte-se usando o facebook</span>
                </a>
            </div>
            <form class="form-modern pop-form" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <label>
                    <span>E-mail</span>
                    <input type="email" name="email" placeholder="informe seu e-mail" value="{{ old('email') }}" data-required="email" required>
                    <span class="alert{{ $errors->has('email') ? '' : ' hidden' }}">{{ $errors->first('email') }}</span>
                </label>
                <label>
                    <span>Senha</span>
                    <input type="password" name="password" placeholder="informe sua senha" data-required="password">
                    <span class="alert{{ $errors->has('password') ? '' : ' hidden' }}">{{ $errors->first('password') }}</span>
                </label>
                <div class="txt-center">
                    <button class="btn btn-popmartin" type="submit" style="padding: 10px 60px;margin-top: 30px;">Entrar</button>
                    <br><br>
                    <a class="txt-decoration-underline c-gray"  href="{{ url('/password/reset') }}" style="margin-top: 10px;">esqueci minha senha</a>
                </div>
            </form>
        </article>
        <article class="colbox-2">
            <header class="pop-title">
                <h1>Quero fazer parte do Pop Martin</h1>
            </header>

            <div class="txt-center">
                <a class="modal modal-blueface" href="">
                    <span><i class="fa fa-facebook-f"></i> | cadastre-se usando o facebook</span>
                </a>
            </div>

            <form class="form-modern pop-form" role="form" method="POST" action="{{ url('/register') }}" novalidate>
                {{ csrf_field() }}
                <label>
                    <span>Nome <sup class="c-red fontem-06 fl-right">obrigatório</sup></span>
                    <input type="text" name="name" placeholder="Ex: João" value="{{ old('name') }}" data-required="name" required>
                    <span class="alert{{ $errors->has('name') ? '' : ' hidden' }}">{{ $errors->first('name') }}</span>
                </label>
                <label>
                    <span>Sobrenome <sup class="c-red fontem-06 fl-right">obrigatório</sup></span>
                    <input type="text" name="last_name" placeholder="Ex: da Silva santos" value="{{ old('last_name') }}" data-required="last_name" required>
                    <span class="alert{{ $errors->has('last_name') ? '' : ' hidden' }}">{{ $errors->first('last_name') }}</span>
                </label>
                <label>
                    <span>E-mail <sup class="c-red fontem-06 fl-right">obrigatório</sup></span>
                    <input type="email" name="email_register" placeholder="Ex: exemplo@exemplo.com" value="{{ old('email_register') }}" data-required="email" required>
                    <span class="alert{{ $errors->has('email_register') ? '' : ' hidden' }}">{{ $errors->first('email_register') }}</span>
                </label>
                <label>
                    <span>Confirmar E-mail <sup class="c-red fontem-06 fl-right">obrigatório</sup></span>
                    <input type="email" name="email_register_confirmation" placeholder="Ex: exemplo@exemplo.com" data-required="email_confirm" required>
                    <span class="alert hidden"></span>
                </label>
                <label>
                    <span>Criar Senha <sup class="c-red fontem-06 fl-right">obrigatório</sup> </span>
                    <input type="password" name="password_register" min="6" max="20" data-required="password" required>
                    <span class="alert{{ $errors->has('password') ? '' : ' hidden' }}">{{ $errors->first('password') }}</span>
                </label>
                <label>
                    <span>Repetir Senha <sup class="c-red fontem-06 fl-right">obrigatório</sup></span>
                    <input type="password" name="password_register_confirmation" min="6" max="20" data-required="password_confirm" required>
                    <span class="alert hidden"></span>
                </label>
                <div style="border: 1px solid #B0BEC5; padding: 10px;">
                    <span>Ao clicar em "Cadastrar", você confirma que aceita o <a href="/info/termos-de-uso">Termos de Uso</a> e <a
                                href="/info/politicas-de-privacidade">Politica de Privacidade</a> .</span>
                </div>
                <div class="txt-center" style="padding: 0 30px;margin-top: 20px;">
                    <button class="btn btn-popmartin" type="submit">Cadastrar</button>
                </div>
            </form>
        </article>
    </div>
    <div class="clear-both"></div>
</section>
@endsection
