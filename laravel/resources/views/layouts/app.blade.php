<!DOCTYPE html>
<html lang="br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PopMartin</title>

        <link href="/public/frontend/css/bootstrap.css" rel="stylesheet">
        <link href="/public/frontend/lib/owlcarousel/owl.carousel.min.css" rel="stylesheet">
        <link href="/public/frontend/lib/owlcarousel/theme/owl.theme.default.min.css" rel="stylesheet">
        <link href="/public/frontend/lib/tooltipster/css/tooltipster.bundle.min.css" rel="stylesheet">
        <link href="/public/frontend/lib/alertfy/css/alertify.min.css" rel="stylesheet">
        <link href="/public/frontend/lib/alertfy/css/themes/semantic.rtl.min.css" rel="stylesheet">
        @yield('css')
        <link href="/public/css/popmartin.css" rel="stylesheet">


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
        <script src="/public/frontend/js/jquery1.js"></script>
        <script src="/public/frontend/lib/jqueryui/jquery-ui.min.js"></script>
        <script src="/public/frontend/lib/maskinput/jquery.mask.min.js"></script>
        <script src="/public/frontend/lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="/public/frontend/lib/tooltipster/js/tooltipster.bundle.min.js"></script>
        <script src="/public/frontend/lib/alertfy/alertify.min.js"></script>
        {{--<script src="/frontend/lib/twbsPagination/jquery.twbsPagination.min.js"></script>--}}
        <script src="/public/frontend/js/bootstrap.js"></script>
        <script src="{{ url('/js/popmartin.js') }}"></script>
        @yield('script')
        @if (session()->has('flash_notification.message'))
            <script>
                var alert = '{{ session('flash_notification.level') }}';
                var message = '{!! session('flash_notification.message') !!}';
                console.log(alert);
                if(alert == 'accept'){
                    alertify.success(message);
                }else{
                    alertify.error(message);
                }
            </script>
        @endif
    </body>
</html>