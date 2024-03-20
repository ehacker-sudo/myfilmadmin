<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Y Tế Box</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Site favicon -->
	{{-- <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendors/images/logo_2.png')}}"/> --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendors/images/logo_2.png')}}"/>
    {{-- <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendors/images/logo_2.png')}}"/> --}}

    <link rel="stylesheet" type="text/css" href="{{ asset('src/plugins/jquery-steps/jquery.steps.css')}}"/>
    <!-- Google Font -->
    @yield('css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/core.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/icon-font.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/style.css')}}" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());

        gtag("config", "G-GBZ3SGGX85");
    </script>
    <!-- Google Tag Manager -->
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({ "gtm.start": new Date().getTime(), event: "gtm.js" });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != "dataLayer" ? "&l=" + l : "";
            j.async = true;
            j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, "script", "dataLayer", "GTM-NXZMQSS");
    </script>
    <!-- End Google Tag Manager -->
    <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
</head>
<body>
    @guest
        <div class="login-header box-shadow">
            <div
                class="container-fluid d-flex justify-content-between align-items-center">
                <div class="brand-logo">
                    <a href="{{ url('/') }}">
                        <img
                            src="{{ asset('vendors/images/logo_2.png')}}"
                            alt=""
                            class="light-logo" width="60"
                        />&NoBreak;&NoBreak;&NoBreak;
                        <span class="brand-text" style="color: black">Y Tế Box</span>
                    </a>
                </div>
                
                
                @yield('register')
                @yield('login')
            </div>
        </div>
        <main class="py-4">
            @yield('content')
        </main>
        <script src="{{ asset('vendors/scripts/core.js')}}"></script>
        <script src="{{ asset('vendors/scripts/script.min.js')}}"></script>
        <script src="{{ asset('vendors/scripts/process.js')}}"></script>
        <script src="{{ asset('src/plugins/jquery-steps/jquery.steps.js')}}"></script>
        <script src="{{ asset('vendors/scripts/steps-setting.js')}}"></script>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0" style="display: none; visibility: hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    @else
        @include('layouts.bar.header')
        @include('layouts.bar.sidebar')
            @yield('content')
        @yield('script')
        @if (session()->has('status'))
            <script>
                swal(
                        {
                            title: "{!! session()->get('status') !!}",
                            text: '',
                            type: 'success',
                            showCancelButton: true,
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger'
                        }
                    )
            </script>
        @endif
    @endguest
</body>
</html>
