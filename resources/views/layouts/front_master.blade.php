<!doctype html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="with=device-width, initial-scale=1.0" />
    <title>
        @yield('title')
    </title>

    @if (is_object($home_setting) && isset($home_setting))
    <link rel="icon" type="image/x-icon"
        href="{{ asset('uploaded-images/home-setting-images/' . $home_setting->image) }}">
    @else
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HHG3N9HYB7"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-HHG3N9HYB7');
    </script>

    @include('layouts.front_includes.link')
</head>

<body>
    @include('layouts.front_includes.parallax_bg')
    @include('layouts.front_includes.header')
    @yield('content')
    @include('layouts.front_includes.footer')
    @include('layouts.front_includes.cat_eyes')
    @include('layouts.front_includes.script')
</body>

</html>