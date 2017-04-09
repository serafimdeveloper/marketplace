@section('script_int')
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
@endsection
