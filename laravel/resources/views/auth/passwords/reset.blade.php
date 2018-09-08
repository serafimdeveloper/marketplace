@extends('layouts.app')

@section('content')
<section class="content">
    <header class="pop-title">
        <h1>Nova senha</h1>
    </header>

    <div>
        @if (session('status'))
            <div class="trigger accept">
                {{ session('status') }}
            </div>
        @endif

        <div style="max-width: 400px; margin: 0 auto;">
            <form class="form-modern pop-form" method="POST" action="{{ url('/password/reset') }}">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                <label>
                    <span>E-mail</span>
                    <input type="email" name="email" value="{{ $email or old('email') }}" placeholder="e-mail" data-required="email" required autofocus>
                    <span class="alert {{ $errors->has('email') ? '' : 'hidden' }}"></span>
                </label>
                <label>
                    <span>Nova senha</span>
                    <input type="password" class="form-control" name="password" placeholder="nova senha" data-required="password" required>
                    <span class="alert {{ $errors->has('password') ? '' : 'hidden' }}"></span>
                </label>
                <label>
                    <span>Repetir senha</span>
                    <input type="password" name="password_confirmation" placeholder="repetir senha" data-required="password_confirmation" required>
                    <span class="alert {{ $errors->has('password_confirmation') ? '' : 'hidden' }}"></span>
                </label>
                <div class="txt-center">
                    <button type="submit" class="btn btn-popmartin">Redefinir senha</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
