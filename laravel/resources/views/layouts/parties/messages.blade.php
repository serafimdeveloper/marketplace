@section('script')
    @if (session()->has('flash_notification.message'))
        <script>
            var alert = '{{ session('flash_notification.level') }}';
            var message = '{!! session('flash_notification.message') !!}';
            console.log(alert);
            if(alert === 'accept'){
                alertify.success(message);
            }else{
                alertify.error(message);
            }
        </script>
    @endif
    <script src="{{ url('/js/panel.js') }}"></script>
@endsection
