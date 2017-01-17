<!DOCTYPE html>
<html lang="br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>PopMartin</title>

        <!-- Bootstrap -->
        {{--<link href="/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet">--}}
        <link href="/frontend/css/bootstrap.css" rel="stylesheet">
        <link href="/frontend/lib/owlcarousel/owl.carousel.min.css" rel="stylesheet">
        <link href="/frontend/lib/owlcarousel/theme/owl.theme.default.min.css" rel="stylesheet">
        <link href="/css/popmartin.css" rel="stylesheet">


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <main class="container">
@include('inc.header')
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

            <form class="form-modern" action="" method="POST">
                <label>
                    <span>Nome</span>
                    <input type="text" name="name" placeholder="João">
                    <span class="alert hidden"></span>
                </label>
                <label>
                    <span>E-mail</span>
                    <input type="email" name="email" placeholder="exemplo@exemplo.com">
                    <span class="alert hidden"></span>
                </label>
                <label>
                    <span>Confirmar E-mail</span>
                    <input type="email" name="email_repeat" placeholder="exemplo@exemplo.com">
                    <span class="alert hidden"></span>
                </label>
                <label>
                    <span>Criar Senha</span>
                    <input type="password" name="password">
                    <span class="alert hidden"></span>
                </label>
                <label>
                    <span>Repetir Senha</span>
                    <input type="password" name="password">
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
@include('inc.footer')
 </main>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="/frontend/js/jquery1.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/frontend/lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="/frontend/js/bootstrap.js"></script>
        <script src="{{ url('/js/popmartin.js') }}"></script>
    </body>
</html>