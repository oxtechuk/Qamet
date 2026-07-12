@php
    $logo = \App\Models\Setting::where('key', 'site_logo')->first()?->value;
    $siteName = \App\Models\Setting::where('key', 'site_name')->first()?->value;
    $siteNameText = is_array($siteName) ? ($siteName[app()->getLocale()] ?? ($siteName['ar'] ?? 'GR Motors')) : ($siteName ?? 'GR Motors');
    $currentUser = auth()->guard('employee')->user();
    $r = request()->route()?->getName() ?? '';

    // Helper: check if any route in a group is active
    $groupActive = function(array $prefixes) use ($r) {
        foreach ($prefixes as $prefix) {
            if (str_starts_with($r, $prefix)) return true;
        }
        return false;
    };
@endphp

<aside class="crm-sidebar">

    {{-- Close Button (Mobile Only) --}}
    <button class="crm-sidebar-close" id="crmSidebarClose" aria-label="Close menu">
        <i class="bi bi-x-lg"></i>
    </button>

    {{-- Logo --}}
    <div class="crm-sidebar-logo">
        @if($logo)
            <img src="{{ asset('storage/' . $logo) }}" alt="{{ $siteNameText }}">
        @else
            <div style="display:flex;align-items:center;justify-content:center;gap:5px;">
                <span style="font-size:20px;font-weight:900;color:var(--crm-red);">GR</span>
                <span style="font-size:12px;font-weight:800;color:var(--crm-text);">Motors</span>
            </div>
        @endif
    </div>

    {{-- Navigation --}}
    <nav class="crm-nav">

        {{-- ● الرئيسية --}}
        @can('manage-dashboard')
        <div class="crm-nav-section">
            <a href="{{ route('crm.dashboard') }}"
               class="crm-nav-link {{ str_starts_with($r,'crm.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i>
                <span>{{ __('الرئيسية') }}</span>
            </a>
        </div>
        @endcan

        {{-- ● الكتالوج --}}
        @php
            $catOpen = $groupActive(['crm.cars','crm.brands','crm.brand-types','crm.car-categories','crm.car-types','crm.specifications','crm.features','crm.safety-features','crm.offers']);
            $canCatalog = $currentUser->hasAnyPermission(['manage-cars','manage-brands','manage-brand-types','manage-car-categories','manage-car-types','manage-specifications','manage-features','manage-safety-features','manage-offers']);
        @endphp
        @if($canCatalog)
        <div class="crm-nav-section">
            <button class="crm-nav-link crm-group-toggle {{ $catOpen ? 'active' : '' }}"
                    onclick="toggleGroup('g-catalog')">
                <i class="bi bi-collection"></i>
                <span>{{ __('الكتالوج') }}</span>
                <i class="bi bi-chevron-{{ $catOpen ? 'up' : 'down' }} crm-chevron"></i>
            </button>
            <ul id="g-catalog" class="crm-sub-list {{ $catOpen ? 'open' : '' }}">
                @can('manage-cars')
                <li>
                    <a href="{{ route('crm.cars.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.cars') ? 'active' : '' }}">
                        <i class="bi bi-car-front"></i> {{ __('السيارات') }}
                    </a>
                </li>
                @endcan
                @can('manage-brands')
                <li>
                    <a href="{{ route('crm.brands.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.brands') ? 'active' : '' }}">
                        <i class="bi bi-bookmark-star"></i> {{ __('الماركات') }}
                    </a>
                </li>
                @endcan
                @can('manage-brand-types')
                <li>
                    <a href="{{ route('crm.brand-types.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.brand-types') ? 'active' : '' }}">
                        <i class="bi bi-bookmarks"></i> {{ __('أنواع الماركات') }}
                    </a>
                </li>
                @endcan
                @can('manage-car-categories')
                <li>
                    <a href="{{ route('crm.car-categories.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.car-categories') ? 'active' : '' }}">
                        <i class="bi bi-folder2-open"></i> {{ __('التصنيفات') }}
                    </a>
                </li>
                @endcan
                @can('manage-car-types')
                <li>
                    <a href="{{ route('crm.car-types.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.car-types') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i> {{ __('الأنواع') }}
                    </a>
                </li>
                @endcan
                @can('manage-specifications')
                <li>
                    <a href="{{ route('crm.specifications.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.specifications') ? 'active' : '' }}">
                        <i class="bi bi-gear-wide-connected"></i> {{ __('المواصفات') }}
                    </a>
                </li>
                @endcan
                @can('manage-features')
                <li>
                    <a href="{{ route('crm.features.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.features') ? 'active' : '' }}">
                        <i class="bi bi-list-check"></i> {{ __('المميزات') }}
                    </a>
                </li>
                @endcan
                @can('manage-safety-features')
                <li>
                    <a href="{{ route('crm.safety-features.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.safety-features') ? 'active' : '' }}">
                        <i class="bi bi-shield-check"></i> {{ __('ميزات السلامة') }}
                    </a>
                </li>
                @endcan
                @can('manage-offers')
                <li>
                    <a href="{{ route('crm.offers.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.offers') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i> {{ __('العروض') }}
                    </a>
                </li>
                @endcan
            </ul>
        </div>
        @endif

        {{-- ● إدارة العملاء --}}
        @php
            $custOpen = $groupActive(['crm.leads','crm.calculator-leads','crm.contact-sources','crm.newsletter']);
            $canCustomers = $currentUser->hasAnyPermission(['manage-leads','manage-calculator-leads','manage-contact-sources','manage-newsletter']);
        @endphp
        @if($canCustomers)
        <div class="crm-nav-section">
            <button class="crm-nav-link crm-group-toggle {{ $custOpen ? 'active' : '' }}"
                    onclick="toggleGroup('g-clients')">
                <i class="bi bi-people"></i>
                <span>{{ __('إدارة العملاء') }}</span>
                <i class="bi bi-chevron-{{ $custOpen ? 'up' : 'down' }} crm-chevron"></i>
            </button>
            <ul id="g-clients" class="crm-sub-list {{ $custOpen ? 'open' : '' }}">
                @can('manage-leads')
                <li>
                    <a href="{{ route('crm.leads.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.leads') ? 'active' : '' }}">
                        <i class="bi bi-person-lines-fill"></i> {{ __('العملاء') }}
                        <span class="nav-badge new-leads-badge ms-auto" style="display:none;">0</span>
                    </a>
                </li>
                @endcan
                @can('manage-calculator-leads')
                <li>
                    <a href="{{ route('crm.calculator-leads.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.calculator-leads') ? 'active' : '' }}">
                        <i class="bi bi-person-badge"></i> {{ __('عملاء الحاسبة') }}
                    </a>
                </li>
                @endcan
                @can('manage-contact-sources')
                <li>
                    <a href="{{ route('crm.contact-sources.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.contact-sources') ? 'active' : '' }}">
                        <i class="bi bi-broadcast"></i> {{ __('مصادر التواصل') }}
                    </a>
                </li>
                @endcan
                @can('manage-newsletter')
                <li>
                    <a href="{{ route('crm.newsletter.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.newsletter') ? 'active' : '' }}">
                        <i class="bi bi-envelope-heart"></i> {{ __('مشتركو النشرة') }}
                    </a>
                </li>
                @endcan
            </ul>
        </div>
        @endif

        {{-- ● المبيعات --}}
        @php
            $salesOpen = $groupActive(['crm.bookings','crm.tracking','crm.calculator.index']);
            $canSales = $currentUser->hasAnyPermission(['manage-bookings','manage-tracking','manage-calculator-settings']);
        @endphp
        @if($canSales)
        <div class="crm-nav-section">
            <button class="crm-nav-link crm-group-toggle {{ $salesOpen ? 'active' : '' }}"
                    onclick="toggleGroup('g-sales')">
                <i class="bi bi-bag"></i>
                <span>{{ __('المبيعات') }}</span>
                <i class="bi bi-chevron-{{ $salesOpen ? 'up' : 'down' }} crm-chevron"></i>
            </button>
            <ul id="g-sales" class="crm-sub-list {{ $salesOpen ? 'open' : '' }}">
                @can('manage-bookings')
                <li>
                    <a href="{{ route('crm.bookings.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.bookings') ? 'active' : '' }}">
                        <i class="bi bi-calendar-check"></i> {{ __('الطلبات') }}
                    </a>
                </li>
                @endcan
                @can('manage-tracking')
                <li>
                    <a href="{{ route('crm.tracking.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.tracking') ? 'active' : '' }}">
                        <i class="bi bi-kanban"></i> {{ __('تتبع الحالات') }}
                    </a>
                </li>
                @endcan
                @can('manage-calculator-settings')
                <li>
                    <a href="{{ route('crm.calculator.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.calculator.index') ? 'active' : '' }}">
                        <i class="bi bi-calculator"></i> {{ __('إعدادات الحاسبة') }}
                    </a>
                </li>
                @endcan
            </ul>
        </div>
        @endif

        {{-- ● الفرق والمهام --}}
        @php
            $teamOpen = $groupActive(['crm.tasks','crm.employees','crm.roles']);
            $canTeam = $currentUser->hasAnyPermission(['manage-tasks','manage-employees','manage-roles']);
        @endphp
        @if($canTeam)
        <div class="crm-nav-section">
            <button class="crm-nav-link crm-group-toggle {{ $teamOpen ? 'active' : '' }}"
                    onclick="toggleGroup('g-team')">
                <i class="bi bi-people-fill"></i>
                <span>{{ __('الفرق والمهام') }}</span>
                <i class="bi bi-chevron-{{ $teamOpen ? 'up' : 'down' }} crm-chevron"></i>
            </button>
            <ul id="g-team" class="crm-sub-list {{ $teamOpen ? 'open' : '' }}">
                @can('manage-tasks')
                <li>
                    <a href="{{ route('crm.tasks.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.tasks') ? 'active' : '' }}">
                        <i class="bi bi-check2-square"></i> {{ __('المهام') }}
                    </a>
                </li>
                @endcan
                @can('manage-employees')
                <li>
                    <a href="{{ route('crm.employees.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.employees') ? 'active' : '' }}">
                        <i class="bi bi-person-workspace"></i> {{ __('الموظفين') }}
                    </a>
                </li>
                @endcan
                @can('manage-roles')
                <li>
                    <a href="{{ route('crm.roles.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.roles') ? 'active' : '' }}">
                        <i class="bi bi-shield-check"></i> {{ __('الأدوار والصلاحيات') }}
                    </a>
                </li>
                @endcan
            </ul>
        </div>
        @endif

        {{-- ● التقارير --}}
        @can('manage-reports')
        <div class="crm-nav-section">
            <a href="{{ route('crm.reports.bookings') }}"
               class="crm-nav-link {{ str_starts_with($r,'crm.reports') ? 'active' : '' }}">
                <i class="bi bi-graph-up-arrow"></i>
                <span>{{ __('التقارير') }}</span>
            </a>
        </div>
        @endcan

        {{-- ● المحتوى والإعدادات --}}
        @php
            $contentOpen = $groupActive(['crm.blog','crm.blog-categories','crm.settings.designs','crm.settings.partners','crm.settings.testimonials','crm.settings.faqs','crm.translations']);
            $canContent = $currentUser->hasAnyPermission(['manage-blog','manage-designs','manage-partners','manage-testimonials','manage-faqs','manage-translations']);
        @endphp
        @if($canContent)
        <div class="crm-nav-section">
            <button class="crm-nav-link crm-group-toggle {{ $contentOpen ? 'active' : '' }}"
                    onclick="toggleGroup('g-content')">
                <i class="bi bi-journal-richtext"></i>
                <span>{{ __('المحتوى') }}</span>
                <i class="bi bi-chevron-{{ $contentOpen ? 'up' : 'down' }} crm-chevron"></i>
            </button>
            <ul id="g-content" class="crm-sub-list {{ $contentOpen ? 'open' : '' }}">
                @can('manage-blog')
                <li>
                    <a href="{{ route('crm.blog.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.blog') && !str_contains($r,'crm.blog-categories') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text"></i> {{ __('المدونة') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('crm.blog-categories.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.blog-categories') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i> {{ __('تصنيفات المقالات') }}
                    </a>
                </li>
                @endcan
                @can('manage-designs')
                <li>
                    <a href="{{ route('crm.settings.designs.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.settings.designs') ? 'active' : '' }}">
                        <i class="bi bi-palette"></i> {{ __('معرض التصاميم') }}
                    </a>
                </li>
                @endcan
                @can('manage-partners')
                <li>
                    <a href="{{ route('crm.settings.partners.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.settings.partners') ? 'active' : '' }}">
                        <i class="bi bi-hand-thumbs-up"></i> {{ __('شركاء النجاح') }}
                    </a>
                </li>
                @endcan
                @can('manage-testimonials')
                <li>
                    <a href="{{ route('crm.settings.testimonials.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.settings.testimonials') ? 'active' : '' }}">
                        <i class="bi bi-chat-quote"></i> {{ __('آراء العملاء') }}
                    </a>
                </li>
                @endcan
                @can('manage-faqs')
                <li>
                    <a href="{{ route('crm.settings.faqs.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.settings.faqs') ? 'active' : '' }}">
                        <i class="bi bi-question-circle"></i> {{ __('الأسئلة الشائعة') }}
                    </a>
                </li>
                @endcan
                @can('manage-translations')
                <li>
                    <a href="{{ route('crm.translations.index') }}"
                       class="crm-sub-link {{ str_starts_with($r,'crm.translations') ? 'active' : '' }}">
                        <i class="bi bi-translate"></i> {{ __('إدارة الترجمة') }}
                    </a>
                </li>
                @endcan
            </ul>
        </div>
        @endif

    </nav>

    {{-- Footer --}}
    <div class="crm-sidebar-footer">
        @can('manage-settings-integrations')
        <a href="{{ route('crm.settings.integrations') }}"
           class="crm-nav-link {{ str_starts_with($r,'crm.settings.integrations') ? 'active' : '' }}">
            <i class="bi bi-plugin"></i>
            <span>{{ __('الربط والإشعارات') }}</span>
        </a>
        @endcan
        @can('manage-settings')
        <a href="{{ route('crm.settings.general') }}"
           class="crm-nav-link {{ str_starts_with($r,'crm.settings.general') || (str_starts_with($r,'crm.settings') && !$contentOpen && !str_starts_with($r,'crm.settings.integrations')) ? 'active' : '' }}">
            <i class="bi bi-gear"></i>
            <span>{{ __('الإعدادات') }}</span>
        </a>
        @endcan
        <form action="{{ route('crm.logout') }}" method="POST">
            @csrf
            <button type="submit" class="crm-nav-link w-100" style="background:none;border:none;cursor:pointer;color:#299BE0;">
                <i class="bi bi-box-arrow-right"></i>
                <span>{{ __('تسجيل الخروج') }}</span>
            </button>
        </form>
    </div>

</aside>

<script>
function toggleGroup(id) {
    const list = document.getElementById(id);
    const btn  = list.previousElementSibling;
    const icon = btn.querySelector('.crm-chevron');
    const isOpen = list.classList.contains('open');
    // Close all others
    document.querySelectorAll('.crm-sub-list.open').forEach(el => {
        el.classList.remove('open');
        const b = el.previousElementSibling;
        if (b) { b.classList.remove('active'); const ic = b.querySelector('.crm-chevron'); if(ic) ic.className = 'bi bi-chevron-down crm-chevron'; }
    });
    if (!isOpen) {
        list.classList.add('open');
        btn.classList.add('active');
        if (icon) icon.className = 'bi bi-chevron-up crm-chevron';
    }
}
</script>
