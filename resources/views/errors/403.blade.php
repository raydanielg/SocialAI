
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no,  maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    @include('layouts.default.head')

    <meta name="app-name" content="{{ config('app.name') }}" />
    <title inertia>{{ SeoMeta::get('title') ?? SeoMeta::get('site_name') }} - {{ config('app.name') }}</title>
    <meta name="description" itemprop="description" inertia content="{{ SeoMeta::get('description') }}" />
    <meta name="keywords" inertia content="{{ SeoMeta::get('keywords') }}" />
    <meta property="og:description" inertia content="{{ SeoMeta::get('description') }}" />
    <meta property="og:title" inertia content="{{ SeoMeta::get('site_name') }}" />
    <meta property="og:url" inertia content="{{ request()->fullUrl() }}" />

    <meta property="og:site_name" inertia content="{{ SeoMeta::get('site_name') }}" />
    <meta property="og:image" inertia content="{{ SeoMeta::get('preview') }}" />
    <meta property="og:image:url" inertia content="{{ SeoMeta::get('preview') }}" />

    <meta name="twitter:card" inertia content="{{ SeoMeta::get('description') }}" />
    <meta name="twitter:title" inertia content="{{ SeoMeta::get('site_name') }}" />

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
                           <h4 class="error-title-sm">{{ __('Oops.! Access Denied!') }}</h4>
                           <p>{{ __('You do not have permission to access this page') }}</p>
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

