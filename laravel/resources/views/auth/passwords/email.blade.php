@extends('layouts.app')

<!-- Main Content -->
@section('content')
    <section class="content">
        <header class="pop-title">
            <h1>Recuperar acesso</h1>
        </header>
        @if (session('status'))
            <div class="trigger accept">
                {{ session('status') }}
            </div>
        @endif
        <br>
        <div style="max-width: 400px; margin: 0 auto;">

            <p class="txt-center">
                Informe seu e-mail de cadastro no Pop Martin.
                Um email contendo um link será enviado para que possa redefinir sua senha
            </p>
            <form class="form-modern pop-form" method="POST" action="{{ url('/password/email') }}">
                {{ csrf_field() }}
                <label>
                    <input type="email" name="email" value="{{ old('email') }} " placeholder="e-mail de cadastro" data-required="email" required>
                    <span class="alert {{ $errors->has('email') ? '' : 'hidden' }}">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                </label>
                <div class="txt-center">
                    <button type="submit" class="btn btn-popmartin">Enviar link</button>
                </div>
            </form>
        </div>
    </section>
@endsection
