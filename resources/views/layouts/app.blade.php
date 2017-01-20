<!DOCTYPE html>
<html lang="br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PopMartin</title>

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
            @include('layouts.parties.messages')
            @yield('content')
            @include('inc.footer')
        </main>
        <script src="/frontend/js/jquery1.js"></script>
        <script src="/frontend/js/jquery.maskedinput.min.js"></script>
        <script src="/frontend/lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="/frontend/js/bootstrap.js"></script>
        <script src="{{ url('/js/popmartin.js') }}"></script>
        <script>
            jQuery(function($){
                $(".masked_date").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
                $(".masked_phone").mask("(999) 999-9999");
                $(".masked_cpf").mask("999.999.999-99");
                $(".masked_cnpj").mask("99.999.999/9999-99");
            });
        </script>
    </body>
</html>