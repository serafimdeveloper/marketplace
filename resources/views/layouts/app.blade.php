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
            @yield('content')
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