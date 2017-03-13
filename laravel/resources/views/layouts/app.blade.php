<!DOCTYPE html>
<html lang="br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PopMartin</title>
        <link href="{{asset('frontend/css/bootstrap.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/lib/owlcarousel/owl.carousel.min.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/lib/owlcarousel/theme/owl.theme.default.min.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/lib/tooltipster/css/tooltipster.bundle.min.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/lib/alertfy/css/alertify.min.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/lib/alertfy/css/themes/semantic.rtl.min.css')}}" rel="stylesheet">
        @yield('css')
        <link href="{{asset('css/popmartin.css')}}" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.8&appId=1645780162393141";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <main class="container">
            @include('inc.header')
            @yield('content')
            @include('inc.footer')
        </main>
        <script src="{{asset('frontend/js/jquery1.js')}}"></script>
        <script src="{{asset('frontend/lib/jqueryui/jquery-ui.min.js')}}"></script>
        <script src="{{asset('frontend/lib/maskinput/jquery.mask.min.js')}}"></script>
        <script src="{{asset('frontend/lib/owlcarousel/owl.carousel.min.js')}}"></script>
        <script src="{{asset('frontend/lib/tooltipster/js/tooltipster.bundle.min.js')}}"></script>
        <script src="{{asset('frontend/lib/alertfy/alertify.min.js')}}"></script>
        {{--<script src="/frontend/lib/twbsPagination/jquery.twbsPagination.min.js"></script>--}}
        <script src="{{asset('frontend/js/bootstrap.js')}}"></script>
        <script src="{{asset('/js/popmartin.js') }}"></script>
        @yield('script')
        @if (session()->has('flash_notification.message'))
            <script>
                var alert = '{{ session('flash_notification.level') }}';
                var message = '{!! session('flash_notification.message') !!}';
                if(alert == 'accept'){
                    alertify.success(message);
                }else{
                    alertify.error(message);
                }
            </script>
        @endif
    </body>
</html>