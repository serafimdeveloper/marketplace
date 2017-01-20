@extends('layouts.app')

@section('content')
<section class="pop-forms content">
    <div class="colbox">
        <div class="colbox-2">
            <h2>Já sou usuário do Popmartin</h2>
            <div class="txt-center">
                <a class="modal modal-blueface" href="">
                    <span><i class="fa fa-facebook-f"></i> | conecte-se usando o facebook</span>
                </a>
            </div>
            <form class="form-modern" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <label>
                    <span>E-mail</span>
                    <input type="email" name="email" placeholder="informe seu e-mail" value="{{ old('email') }}" required>
                    <span class="alert{{ $errors->has('email') ? '' : ' hidden' }}">{{ $errors->first('email') }}</span>
                </label>
                <label>
                    <span>Senha</span>
                    <input type="password" name="password" placeholder="informe sua senha">
                    <span class="alert{{ $errors->has('password') ? '' : ' hidden' }}">{{ $errors->first('password') }}</span>
                </label>
                <div class="txt-center">
                    <button class="btn btn-popmartin" type="submit" style="padding: 10px 60px;margin-top: 30px;">Entrar</button>
                    <br><br>
                    <a class="txt-decoration-underline c-gray"  href="{{ url('/password/reset') }}" style="margin-top: 10px;">esqueci minha senha</a>
                </div>
            </form>
        </div>
        <div class="colbox-2">
            <h2>Quero fazer parte do Popmartin</h2>
            <div class="txt-center">
                <a class="modal modal-blueface" href="">
                    <span><i class="fa fa-facebook-f"></i> | cadastre-se usando o facebook</span>
                </a>
            </div>

            <form class="form-modern" role="form" method="POST" action="{{ url('/register') }}" novalidate>
                {{ csrf_field() }}
                <label>
                    <span>Nome completo</span>
                    <input type="text" name="name" placeholder="João" value="{{ old('name') }}" required>
                    <span class="alert{{ $errors->has('name') ? '' : ' hidden' }}">{{ $errors->first('name') }}</span>
                </label>
                <label>
                    <span>E-mail</span>
                    <input type="email" name="email" placeholder="exemplo@exemplo.com" value="{{ old('email') }}" required>
                    <span class="alert{{ $errors->has('email') ? '' : ' hidden' }}">{{ $errors->first('email') }}</span>
                </label>
                <label>
                    <span>Confirmar E-mail</span>
                    <input type="email" name="email_confirmation" placeholder="exemplo@exemplo.com" >
                    <span class="alert hidden"></span>
                </label>
                <label>
                    <span>Criar Senha</span>
                    <input type="password" name="password">
                    <span class="alert{{ $errors->has('password') ? '' : ' hidden' }}">{{ $errors->first('password') }}</span>
                </label>
                <label>
                    <span>Repetir Senha</span>
                    <input type="password" name="password_confirmation" required>
                    <span class="alert hidden"></span>
                </label>
                <div style="border: 1px solid #B0BEC5; padding: 10px;">
                    <span>Ao clicar em "Cadastrar", você confirma que aceita o <a href="/termos">Termos de Uso</a> e <a
                                href="/politicas">Politica de Privacidade</a> .</span>
                </div>
                <div class="txt-center" style="padding: 0 30px;margin-top: 20px;">
                    <button class="btn btn-blue" type="submit">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
    <div class="clear-both"></div>
</section>
@endsection
