<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no,  maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>429 - {{ config('app.name') }}</title>
    @include('layouts.default.stylesheets')
</head>

<body>
   <div id="smooth-wrapper">
      <div id="smooth-content">

         <main>
            <div class="tp-error-area tp-error-ptb p-relative">
               <div class="tp-error-left-shape">
                  <img src="/assets/img/login/error-shape.png" alt="">
               </div>
               <div class="container">
                  <div class="row">
                     <div class="col-xl-12">
                        <div class="text-center tp-error-text-box">
                           <h4 class="error-title-sm">429</h4>
                           <p>{{ __('Too Many Requests') }}</p>
                           <a class="tp-btn-inner tp-btn-hover alt-color-black" href="/">
                              <span> {{ __('Back To Home') }}</span>
                              <b></b>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </main>
      </div>
   </div>
</body>
</html>

