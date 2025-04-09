<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.default.head')
    @vite('resources/js/app.js')
    @inertiaHead
    @cookieconsentscripts
    @if(file_exists(base_path('public/uploads/custom_header')))
    {!! file_get_contents(base_path('public/uploads/custom_header')) !!}
    @endif
</head>

<body>
    @routes
    @inertia
    @if (env('COOKIE_CONSENT',false) && !getCookieConsent())
    @cookieconsentview
    @endif

    @if(file_exists(base_path('public/uploads/custom_footer')))
    {!! file_get_contents(base_path('public/uploads/custom_footer')) !!}
    @endif
</body>

</html>