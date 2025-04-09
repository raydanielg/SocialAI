@include('layouts.default.meta')
@include('layouts.default.fonts')
@include('layouts.default.stylesheets')

<link rel="shortcut icon" type="image/x-icon" href="{{ asset(get_option('primary_data')['favicon'] ?? '') }}">
