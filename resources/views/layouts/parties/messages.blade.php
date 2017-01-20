@if (session()->has('flash_notification.message'))
    <div class="ajax-trigger {{ session('flash_notification.level') }}">
        {!! session('flash_notification.message') !!}
    </div>
@endif