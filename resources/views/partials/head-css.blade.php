<!-- Simplebar Css -->
<link rel="stylesheet" href="{{ asset('assets/libs/simplebar/simplebar.min.css') }}">
<!-- Swiper Css -->
<link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
<!-- Nouislider Css -->
<link href="{{ asset('assets/libs/nouislider/nouislider.min.css') }}" rel="stylesheet">
<!-- Bootstrap Css -->
@if(App::getLocale() == 'ar')
    <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css">
@else
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css">
@endif

<!--icons css-->
<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">

<!-- App Css-->
@if(App::getLocale() == 'ar')
    <link href="{{ asset('assets/css/app-rtl.min.css') }}" id="app-style" rel="stylesheet" type="text/css">
@else
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css">
@endif


<style>
    /* Sidebar Collapse & Logo Polish */
    [data-sidebar="icon"] .pe-nav-content,
    [data-sidebar="icon"] .pe-nav-arrow,
    [data-sidebar="icon"] .pe-menu-title {
        display: none !important;
    }
.card-body.p-4.position-relative {
    background: black !important;
}
    [data-sidebar="icon"] .pe-app-sidebar {
        width: 80px !important;
    }

    /* Force correct logo visibility to override d-none utility */
    [data-sidebar="icon"] .pe-app-sidebar-logo-minimize {
        display: block !important;
        margin: 0 auto;
    }
    [data-sidebar="icon"] .pe-app-sidebar-logo-default {
        display: none !important;
    }
    
    /* Show default logo when NOT in icon mode */
    html:not([data-sidebar="icon"]) .pe-app-sidebar-logo-default {
        display: block !important;
    }
    html:not([data-sidebar="icon"]) .pe-app-sidebar-logo-minimize {
        display: none !important;
    }

    /* Center icons in collapsed mode */
    [data-sidebar="icon"] .pe-nav-link {
        justify-content: center !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    [data-sidebar="icon"] .pe-nav-icon {
        margin: 0 !important;
        font-size: 1.25rem !important;
    }
</style>
