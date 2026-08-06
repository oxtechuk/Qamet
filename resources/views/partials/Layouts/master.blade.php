<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<meta charset="utf-8" />
<title>@yield('title', ' | Grand Qemt Najd')</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta content="Qemt Najd CRM" name="description" />
<meta content="Qemt Najd" name="author" />

<!-- layout setup -->
<script type="module" src="{{ asset('assets/js/layout-setup.js') }}"></script>

<!-- App favicon -->
<link rel="shortcut icon" href="{{ asset('assets/images/k_favicon_32x.png') }}">

@yield('css')
@include('partials.head-css')

<body>

    @include('partials.header')
    @include('partials.sidebar')
    @include('partials.horizontal')

    <main class="app-wrapper">
        <div class="container-fluid">

            @include('partials.page-title')

            @yield('content')
            @include('partials.switcher')
            @include('partials.scroll-to-top')
            @include('partials.footer')

            @include('partials.vendor-scripts')

            @yield('js')

</body>

</html>
