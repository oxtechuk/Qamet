<aside class="pe-app-sidebar" id="sidebar">
    <div class="pe-app-sidebar-logo px-6 d-flex align-items-center position-relative">
        <!--begin::Brand Image-->
        <a href="{{ route('crm.dashboard') }}" class="fs-18 fw-semibold">

            <img height="30" class="pe-app-sidebar-logo-light d-none" alt="Logo"
                src="{{ asset('assets/images/logo-light.png') }}">
            <img height="30" class="pe-app-sidebar-logo-minimize d-none" alt="Logo"
                src="{{ asset('assets/images/logo-md.png') }}">
        </a>
        <!--end::Brand Image-->
    </div>
    <nav class="pe-app-sidebar-menu nav nav-pills" data-simplebar id="sidebar-simplebar">
        <ul class="pe-main-menu list-unstyled">

            {{-- ===== الرئيسية ===== --}}
            <li class="pe-menu-title">{{ __('الرئيسية') }}</li>

            <li class="pe-slide">
                <a href="{{ route('crm.dashboard') }}" class="pe-nav-link">
                    <i class="bi bi-speedometer2 pe-nav-icon"></i>
                    <span class="pe-nav-content">{{ __('لوحة التحكم') }}</span>
                </a>
            </li>

            {{-- ===== السيارات ===== --}}
            <li class="pe-menu-title">{{ __('إدارة السيارات') }}</li>

            <li class="pe-slide pe-has-sub">
                <a href="#collapseCars" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false"
                    aria-controls="collapseCars">
                    <i class="bi bi-car-front pe-nav-icon"></i>
                    <span class="pe-nav-content">{{ __('السيارات') }}</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseCars">
                    <li class="pe-slide-item">
                        <a href="{{ route('crm.cars.index') }}" class="pe-nav-link">{{ __('كل السيارات') }}</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="{{ route('crm.cars.create') }}" class="pe-nav-link">{{ __('إضافة سيارة') }}</a>
                    </li>
                </ul>
            </li>

            <li class="pe-slide">
                <a href="{{ route('crm.brands.index') }}" class="pe-nav-link">
                    <i class="bi bi-bookmark-star pe-nav-icon"></i>
                    <span class="pe-nav-content">{{ __('الماركات') }}</span>
                </a>
            </li>

            <li class="pe-slide">
                <a href="{{ route('crm.car-categories.index') }}" class="pe-nav-link">
                    <i class="bi bi-folder2-open pe-nav-icon"></i>
                    <span class="pe-nav-content">{{ __('تصنيفات السيارات') }}</span>
                </a>
            </li>

            <li class="pe-slide">
                <a href="{{ route('crm.offers.index') }}" class="pe-nav-link">
                    <i class="bi bi-tags pe-nav-icon"></i>
                    <span class="pe-nav-content">{{ __('العروض') }}</span>
                </a>
            </li>

            <li class="pe-slide">
                <a href="{{ route('crm.calculator.index') }}" class="pe-nav-link">
                    <i class="bi bi-calculator pe-nav-icon"></i>
                    <span class="pe-nav-content">{{ __('إعدادات الحاسبة') }}</span>
                </a>
            </li>

            {{-- ===== الطلبات (CRM) ===== --}}
            <li class="pe-menu-title">{{ __('إدارة الطلبات') }}</li>

            <li class="pe-slide pe-has-sub">
                <a href="#collapseBookings" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false"
                    aria-controls="collapseBookings">
                    <i class="bi bi-clipboard-check pe-nav-icon"></i>
                    <span class="pe-nav-content">{{ __('الطلبات (Leads)') }}</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseBookings">
                    <li class="pe-slide-item">
                        <a href="{{ route('crm.bookings.index') }}" class="pe-nav-link">{{ __('كل الطلبات') }}</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="{{ route('crm.bookings.index') }}?status=new"
                            class="pe-nav-link">{{ __('طلبات جديدة') }}</a>
                    </li>
                </ul>
            </li>

            <li class="pe-slide pe-has-sub">
                <a href="#collapseClients" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false"
                    aria-controls="collapseClients">
                    <i class="bi bi-person-lines-fill pe-nav-icon"></i>
                    <span class="pe-nav-content">{{ __('العملاء والمتابعة') }}</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseClients">
                    <li class="pe-slide-item">
                        <a href="{{ route('crm.leads.index') }}" class="pe-nav-link">{{ __('العملاء المحتملون') }}</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="{{ route('crm.leads.create') }}" class="pe-nav-link">{{ __('إضافة عميل') }}</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="{{ route('crm.contact-sources.index') }}" class="pe-nav-link">{{ __('مصادر التواصل') }}</a>
                    </li>
                </ul>
            </li>

            <li class="pe-menu-title">{{ __('التقارير') }}</li>

            <li class="pe-slide pe-has-sub">
                <a href="#collapseReports" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false"
                    aria-controls="collapseReports">
                    <i class="bi bi-graph-up-arrow pe-nav-icon"></i>
                    <span class="pe-nav-content">{{ __('تقارير الحجز') }}</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseReports">
                    <li class="pe-slide-item">
                        <a href="{{ route('crm.reports.bookings') }}" class="pe-nav-link">{{ __('تقرير الطلبات') }}</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="{{ route('crm.reports.sources') }}" class="pe-nav-link">{{ __('تقرير المصادر') }}</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="{{ route('crm.reports.monthly') }}" class="pe-nav-link">{{ __('التقرير الشهري') }}</a>
                    </li>
                </ul>
            </li>

            {{-- ===== الفريق ===== --}}
            <li class="pe-menu-title">{{ __('الفريق والمحتوى') }}</li>

            <li class="pe-slide">
                <a href="{{ route('crm.employees.index') }}" class="pe-nav-link">
                    <i class="bi bi-people pe-nav-icon"></i>
                    <span class="pe-nav-content">{{ __('الموظفين') }}</span>
                </a>
            </li>

            <li class="pe-slide pe-has-sub">
                <a href="#collapseBlog" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false"
                    aria-controls="collapseBlog">
                    <i class="bi bi-journal-richtext pe-nav-icon"></i>
                    <span class="pe-nav-content">{{ __('المدونة') }}</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseBlog">
                    <li class="pe-slide-item">
                        <a href="{{ route('crm.blog.index') }}" class="pe-nav-link">{{ __('كل المقالات') }}</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="{{ route('crm.blog.create') }}" class="pe-nav-link">{{ __('كتابة مقالة') }}</a>
                    </li>
                </ul>
            </li>

            {{-- ===== الإعدادات ===== --}}
            <li class="pe-menu-title">{{ __('الإعدادات') }}</li>

            <li class="pe-slide pe-has-sub">
                <a href="#collapseSettings" class="pe-nav-link" data-bs-toggle="collapse" aria-expanded="false"
                    aria-controls="collapseSettings">
                    <i class="bi bi-gear pe-nav-icon"></i>
                    <span class="pe-nav-content">{{ __('إعدادات الموقع') }}</span>
                    <i class="ri-arrow-down-s-line pe-nav-arrow"></i>
                </a>
                <ul class="pe-slide-menu collapse" id="collapseSettings">
                    <li class="pe-slide-item">
                        <a href="{{ route('crm.settings.general') }}" class="pe-nav-link">{{ __('الإعدادات العامة') }}</a>
                    </li>
                    <li class="pe-slide-item">
                        <a href="{{ route('crm.settings.seo') }}" class="pe-nav-link">{{ __('إعدادات SEO') }}</a>
                    </li>
                </ul>
            </li>

            <li class="pe-slide">
                <a href="{{ route('crm.settings.testimonials.index') }}" class="pe-nav-link">
                    <i class="bi bi-chat-quote pe-nav-icon"></i>
                    <span class="pe-nav-content">{{ __('توصيات العملاء') }}</span>
                </a>
            </li>

            <li class="pe-slide">
                <a href="{{ route('crm.settings.partners.index') }}" class="pe-nav-link">
                    <i class="bi bi-hand-thumbs-up pe-nav-icon"></i>
                    <span class="pe-nav-content">{{ __('شركاء النجاح') }}</span>
                </a>
            </li>

            <li class="pe-slide">
                <a href="{{ route('crm.settings.designs.index') }}" class="pe-nav-link">
                    <i class="bi bi-palette pe-nav-icon"></i>
                    <span class="pe-nav-content">{{ __('معرض التصاميم') }}</span>
                </a>
            </li>

            {{-- ===== النظام ===== --}}
            <li class="pe-menu-title">{{ __('النظام') }}</li>

            <li class="pe-slide">
                <a href="#" class="pe-nav-link">
                    <i class="bi bi-box-arrow-right pe-nav-icon"></i>
                    <span class="pe-nav-content">{{ __('تسجيل الخروج') }}</span>
                </a>
            </li>

        </ul>
    </nav>
</aside>