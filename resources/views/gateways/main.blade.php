<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <base href="{{ url('/') }}">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ env('APP_NAME') }} - {{ __('Make Payment') }}</title>
      <!-- Favicon -->
      <link rel="icon" href="{{ asset(get_option('primary_data',true)['favicon'] ?? '') }}" type="image/png">
      <!-- Fonts -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
      <!-- Icons -->
      <link rel="stylesheet" href="{{ asset('assets/gateways/vendor/nucleo/css/nucleo.css') }}" type="text/css">
      <link rel="stylesheet" href="{{ asset('assets/gateways/vendor/@fontawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
      <link rel='stylesheet' href="{{ asset('assets/gateways/css/uicons-regular-straight.css') }}">
      <!-- Page plugins -->
      <link rel="stylesheet" href="{{ asset('assets/gateways/css/argon.css') }}" type="text/css">

      <link rel="stylesheet" type="text/css" href="{{ asset('assets/gateways/plugins/toastify-js/src/toastify.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/gateways/plugins/pace/pace-theme-default.min.css') }}">
      <link href="{{ asset('assets/gateways/css/invoice.css') }}" rel="stylesheet">
      @stack('css')
   </head>
   <body>
      <div class="container py-5 deposit-payment">
         <div class="row justify-content-center">
            <div class="col-sm-12 col-lg-8">
               <div class="card">
                  <div class="card-body">
                     @yield('content')                               
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="{{ asset('assets/gateways/vendor/jquery/dist/jquery.min.js') }}"></script>
      <script src="{{ asset('assets/gateways/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('assets/gateways/vendor/js-cookie/js.cookie.js') }}"></script>
      <script src="{{ asset('assets/gateways/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
      <!-- Plugins  -->
      <script src="{{ asset('assets/gateways/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
      <script src="{{ asset('assets/gateways/plugins/form.js?v=1') }}"></script>
      <script src="{{ asset('assets/gateways/plugins/pace/pace.min.js') }}"></script>
      <script src="{{ asset('assets/gateways/js/argon.js?v=1.1.1') }}"></script>
      @stack('js')   
  
   </body>
</html>