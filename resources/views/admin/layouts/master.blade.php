<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="POS">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="settings-symbol" content="{{ settings('currency_symbol') }}">
    <link rel="shortcut icon" href="{{ settings('favicon') ? asset(settings('favicon')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}">
    @vite('resources/admin_assets/sass/app.scss')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script>
        window.auth_role_permissions = JSON.parse('{!! json_encode(config('auth.role_permissions')) !!}');
    </script>
    @stack('styles')
</head>

<body>
    <div class="container-scroller">
        
        @include('admin.components.navbar')
        
        <div class="container-fluid page-body-wrapper">
            
            @include('admin.components.sidebar')
            
            <div id="app" class="main-panel">

                @yield('content')
                
                @include('admin.components.footer')
                
            </div>
        </div>
    </div>
    
    <script src="{{ asset('assets/js/admin.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/loadingoverlay.min.js') }}"></script>

    <script>
        var dateFormat = "{{ inputDateFormat() }}";
        var inputDateFormat = "{{ inputDateFormat() }}";
        var inputTimeFormat = "{{ inputTimeFormat() }}";
        var inputDateTimeFormat = "{{ inputDateTimeFormat() }}";

        // chack 24h format or 12h format
        var timeFormat = "{{ settings('time_format') }}";

        var hourFormat = false;
        if (timeFormat == '24h') {
            hourFormat = true;
        }
    </script>

    @vite('resources/admin_assets/js/app.js')
    @include('admin.components.flash')
    @stack('scripts')
</body>
</html>
