<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pharmastore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Use Minified Plugins Version For Fast Page Load -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/frontend/css/plugins.css')}}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/frontend/css/main.css')}}" />
    <link rel="stylesheet" href="{{ asset('view_css/frontend/common.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/frontend/image/favicon.ico')}}">
    <script src="{{ asset('assets/frontend/js/plugins.js')}}"></script>
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
    <div class="site-wrapper" id="top">

        @include('layouts.frontend.include.main_header_nav')

        @include('layouts.frontend.include.site_mobile_menu')

        @include('layouts.frontend.include.sticky_menu')


        @yield('content')

        <!--=================================
        Footer
        ===================================== -->
    </div>
    <!--=================================
    Brands Slider
    ===================================== -->
    @include('layouts.frontend.include.brand_slider')
    <!--=================================
    Footer Area
    ===================================== -->

    @include('layouts.frontend.include.footer')

    <!-- Use Minified Plugins Version For Fast Page Load -->

    <script src="{{ asset('assets/frontend/js/ajax-mail.js')}}"></script>
    <script src="{{ asset('assets/frontend/js/custom.js')}}"></script>
    @yield('scripts')
    <script src="{{ asset('view_js/frontend/app.js')}}"></script>
    <script>
        "use strict";

        //GLOBAL 
        var currencySymbol = '{{ isset($settings) ? $settings->currency_symbol ?? "Currency Not Set " : "Currency Not Set " }}';
        var cartUrl = "{{route('cart')}}";
        var checkoutUrl = "{{route('checkout')}}";
        var storeCartUrl = '{{route("storecart")}}';

        var cart;
        @if(session('cart_data'))
        cart = @json(session('cart_data'));
        @else
        cart = [];
        @endif
    </script>

</body>

</html>