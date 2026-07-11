<!-- Begin Header -->
<header class="app-header" id="appHeader">
    <div class="container-fluid w-100">
        <div class="d-flex align-items-center">

            <div class="me-auto">
                <div class="d-inline-flex align-items-center gap-5">
                    <a href="{{ route('crm.dashboard') }}" class="fs-18 fw-semibold">
                        <img height="30" class="header-sidebar-logo-default d-none" alt="Logo"
                            src="{{ asset('assets/images/logo.png') }}">
                        <img height="30" class="header-sidebar-logo-light d-none" alt="Logo"
                            src="{{ asset('assets/images/logo.png') }}">
                    </a>
                    <button type="button"
                        class="vertical-toggle btn btn-light-light text-muted icon-btn fs-5 rounded-pill"
                        id="toggleSidebar">
                        <i class="bi bi-arrow-bar-left header-icon"></i>
                    </button>
                </div>
            </div>

            <div class="flex-shrink-0 d-flex align-items-center gap-3">

                {{-- Language Switcher --}}
                <div class="dropdown">
                    <button class="btn btn-icon header-btn p-1 border rounded" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="{{ App::getLocale() == 'ar' ? asset('assets/images/flag/sa.svg') : asset('assets/images/flag/us.svg') }}"
                            alt="Flag Image" height="20" width="20" class="object-fit-cover rounded">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                                href="{{ route('lang.switch', 'en') }}">
                                <img src="{{ asset('assets/images/flag/us.svg') }}" alt="Flag Image" height="16"
                                    width="16">
                                English
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                                href="{{ route('lang.switch', 'ar') }}">
                                <img src="{{ asset('assets/images/flag/sa.svg') }}" alt="Flag Image" height="16"
                                    width="16">
                                العربية
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Dark/Light Mode --}}
                <div class="dark-mode-btn border rounded" id="toggleMode">
                    <button class="btn header-btn active" id="lightModeBtn"><i
                            class="bi bi-brightness-high"></i></button>
                    <button class="btn header-btn" id="darkModeBtn"><i class="bi bi-moon-stars"></i></button>
                </div>

                {{-- Profile Dropdown --}}
                <div class="dropdown">
                    <button class="header-profile-btn btn border rounded p-1 d-flex align-items-center gap-2"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/images/avatar/avatar-10.jpg') }}" alt="Avatar"
                            class="avatar-sm rounded-circle" style="width:32px; height:32px;">
                        <div class="d-none d-lg-block text-start">
                            <span
                                class="d-block fs-13 fw-semibold lh-1">{{ Auth::guard('employee')->user()->name }}</span>
                            <small class="text-muted">{{ __(ucfirst(Auth::guard('employee')->user()->role)) }}</small>
                        </div>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end shadow border-0 p-3" style="min-width: 220px;">
                        <div class="border-bottom pb-2 mb-2 d-flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/avatar/avatar-10.jpg') }}" alt="Avatar"
                                class="avatar-md rounded-circle">
                            <div>
                                <h6 class="mb-0">{{ Auth::guard('employee')->user()->name }}</h6>
                                <p class="mb-0 fs-12 text-muted text-truncate" style="max-width: 140px;">
                                    {{ Auth::guard('employee')->user()->email }}</p>
                            </div>
                        </div>
                        <ul class="list-unstyled mb-0">
                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-2"></i>
                                    {{ __('الملف الشخصي') }}</a></li>
                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-gear me-2"></i>
                                    {{ __('الإعدادات') }}</a></li>
                            <li class="border-top mt-2 pt-2">
                                <form action="{{ route('crm.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2">
                                        <i class="bi bi-box-arrow-right me-2"></i> {{ __('تسجيل خروج') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>
</header>