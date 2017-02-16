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
        <link href="/frontend/lib/tooltipster/css/tooltipster.bundle.min.css" rel="stylesheet">
        <link href="/frontend/lib/alertfy/css/alertify.min.css" rel="stylesheet">
        <link href="/frontend/lib/alertfy/css/themes/semantic.rtl.min.css" rel="stylesheet">
        @yield('css')
        <link href="/css/popmartin.css" rel="stylesheet">


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
        <script src="/frontend/lib/jqueryui/jquery-ui.min.js"></script>
        <script src="/frontend/lib/maskinput/jquery.mask.min.js"></script>
        <script src="/frontend/lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="/frontend/lib/tooltipster/js/tooltipster.bundle.min.js"></script>
        <script src="/frontend/lib/bsdialog/jquery.bsdialog.js"></script>
        <script src="/frontend/lib/alertfy/alertify.min.js"></script>
        {{--<script src="/frontend/lib/twbsPagination/jquery.twbsPagination.min.js"></script>--}}
        <script src="/frontend/js/bootstrap.js"></script>
        <script src="{{ url('/js/popmartin.js') }}"></script>
        @yield('script')
    </body>
</html>