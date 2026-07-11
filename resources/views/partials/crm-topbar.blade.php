@php
    $currentUser = auth()->guard('employee')->user();
    $logo = \App\Models\Setting::where('key', 'site_logo')->first()?->value;
@endphp
<header class="crm-topbar">

    {{-- Hamburger (Mobile Only) --}}
    <button class="crm-mob-toggle" id="crmMobToggle" aria-label="Open menu">
        <i class="bi bi-list"></i>
    </button>

    {{-- يسار: مستخدم --}}
    <div class="dropdown">
        <div class="crm-topbar-user" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
            <div class="crm-user-avatar shadow-sm">
                @if($currentUser?->avatar)
                    <img src="{{ asset('storage/'.$currentUser->avatar) }}" alt="{{ $currentUser->name }}">
                @else
                    {{ strtoupper(substr($currentUser?->name ?? 'A', 0, 1)) }}
                @endif
            </div>
            <div class="d-none d-md-block">
                <div class="crm-user-name">{{ $currentUser?->name ?? 'Admin' }}</div>
            </div>
            <i class="bi bi-chevron-down crm-topbar-user-chevron ms-2"></i>
        </div>
        <ul class="dropdown-menu dropdown-menu-start shadow-lg border-0 rounded-4 mt-2 py-2" aria-labelledby="userDropdown" style="min-width: 200px;">
            <li class="px-3 py-2 border-bottom mb-2">
                <div class="fw-bold small text-muted mb-1">{{ __('مرحباً بك') }}</div>
                <div class="fw-bold text-dark">{{ $currentUser?->name }}</div>
            </li>
            <li>
                <a class="dropdown-item d-flex align-items-center gap-2 py-2 px-3" href="{{ route('crm.profile.index') }}">
                    <i class="bi bi-person-circle text-primary fs-5"></i>
                    <span>{{ __('الملف الشخصي') }}</span>
                </a>
            </li>
            @if($currentUser?->isAdmin())
            <li>
                <a class="dropdown-item d-flex align-items-center gap-2 py-2 px-3" href="{{ route('crm.settings.general') }}">
                    <i class="bi bi-gear-wide-connected text-primary fs-5"></i>
                    <span>{{ __('إعدادات النظام') }}</span>
                </a>
            </li>
            @endif
            <li><hr class="dropdown-divider opacity-50"></li>
            <li>
                <form action="{{ route('crm.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2 px-3 text-danger">
                        <i class="bi bi-box-arrow-right fs-5"></i>
                        <span>{{ __('تسجيل الخروج') }}</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>

    {{-- وسط: بحث --}}
    <div class="crm-topbar-search" style="position: relative;">
        <input type="text" id="global-search-input" placeholder="{{ __('بحث سريع (عملاء، طلبات، موظفين)...') }}" autocomplete="off">
        <i class="bi bi-search search-icon"></i>
        <div id="global-search-results" class="crm-search-dropdown"></div>
    </div>

    <style>
        .crm-search-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 12px 35px rgba(0,0,0,0.12);
            border: 1px solid var(--crm-border);
            max-height: 450px;
            overflow-y: auto;
            z-index: 2000;
            display: none;
            padding: 10px 0;
            animation: slideDown 0.2s ease-out;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .crm-search-dropdown.show { display: block; }
        .crm-search-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            text-decoration: none !important;
            color: var(--crm-text) !important;
            transition: 0.15s;
            border-bottom: 1px solid #f8f9fa;
        }
        .crm-search-item:last-child { border-bottom: none; }
        .crm-search-item:hover { background: var(--crm-red-light); }
        .crm-search-item .icon-box {
            width: 36px; height: 36px; border-radius: 10px; background: #f8f9fa;
            display: flex; align-items: center; justify-content: center; font-size: 18px; color: var(--crm-red);
        }
        .crm-search-item-info { flex: 1; }
        .crm-search-item-title { font-weight: 700; font-size: 13.5px; display: block; margin-bottom: 2px; }
        .crm-search-item-sub { font-size: 11px; color: var(--crm-text-muted); display: block; }
        .crm-search-item-cat { font-size: 10px; font-weight: 800; background: #f0f1f5; padding: 3px 10px; border-radius: 20px; color: #666; white-space: nowrap; }
        .crm-search-no-results { padding: 30px 20px; text-align: center; color: var(--crm-text-muted); font-size: 13px; }

        /* Notification Dropdown Styles */
        .crm-notif-dropdown { width: 340px; border-radius: 16px !important; overflow: hidden; margin-top: 10px !important; }
        .notif-scroll-area { max-height: 380px; overflow-y: auto; }
        .notif-item { display: flex; gap: 12px; padding: 12px 16px; text-decoration: none !important; color: inherit !important; border-bottom: 1px solid #f8f9fa; transition: 0.2s; position: relative; }
        .notif-item:hover { background: #f9f9fb; }
        .notif-item.unread { background: #fef2f2; }
        .notif-item.unread::after { content: ''; position: absolute; top: 12px; left: 12px; width: 6px; height: 6px; background: var(--crm-red); border-radius: 50%; }
        .notif-icon { width: 36px; height: 36px; border-radius: 10px; background: #fff; border: 1px solid #eee; display: flex; align-items: center; justify-content: center; font-size: 16px; color: var(--crm-red); flex-shrink: 0; }
        .notif-content { flex: 1; }
        .notif-title { font-size: 13px; font-weight: 700; display: block; margin-bottom: 2px; color: var(--crm-text); }
        .notif-msg { font-size: 11.5px; color: var(--crm-text-muted); line-height: 1.4; display: block; }
        .notif-time { font-size: 10px; color: #bbb; margin-top: 4px; display: block; }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const notifBadge = document.getElementById('notif-badge-dot');
        const notifContainer = document.getElementById('notif-items-container');
        const dropdownBtn = document.getElementById('notif-dropdown-btn');

        function updateBadge() {
            fetch(`{{ route('crm.notifications.index') }}?only_count=1`)
                .then(r => r.json())
                .then(data => {
                    if (data && data.unread_count > 0) {
                        notifBadge.classList.remove('d-none');
                    } else {
                        notifBadge.classList.add('d-none');
                    }
                }).catch(e => console.error('Badge update failed', e));
        }

        function fetchNotifications() {
            if (!notifContainer) return;
            notifContainer.innerHTML = `<div class="p-4 text-center text-muted"><div class="spinner-border spinner-border-sm mb-2"></div><div>{{ __('جاري التحميل...') }}</div></div>`;
            fetch(`{{ route('crm.notifications.index') }}`)
                .then(r => r.json())
                .then(data => {
                    if (data && data.notifications && data.notifications.length > 0) {
                        notifContainer.innerHTML = '';
                        data.notifications.forEach(n => {
                            const item = document.createElement('a');
                            item.href = n.url;
                            item.className = 'notif-item unread';
                            item.innerHTML = `
                                <div class="notif-icon"><i class="bi ${n.icon}"></i></div>
                                <div class="notif-content">
                                    <span class="notif-title">${n.title}</span>
                                    <span class="notif-msg">${n.message}</span>
                                    <span class="notif-time">${n.created_at}</span>
                                </div>
                            `;
                            item.onclick = (e) => markAsRead(n.id, e);
                            notifContainer.appendChild(item);
                        });
                    } else {
                        notifContainer.innerHTML = `<div class="p-5 text-center text-muted small"><i class="bi bi-bell-slash fs-2 d-block mb-2 opacity-25"></i>{{ __('لا توجد إشعارات جديدة') }}</div>`;
                    }
                }).catch(e => {
                    console.error('Fetch notifications failed', e);
                    notifContainer.innerHTML = `<div class="p-4 text-center text-danger small">{{ __('حدث خطأ أثناء التحميل') }}</div>`;
                });
        }

        // Only update the red dot on page load
        updateBadge();

        // Load full list only when user clicks the bell
        if (dropdownBtn) {
            dropdownBtn.addEventListener('show.bs.dropdown', fetchNotifications);
        }

        window.markAsRead = function(id, event) {
            fetch(`{{ url('/crm/notifications') }}/${id}/read`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
        }

        window.markAllAsRead = function() {
            fetch(`{{ route('crm.notifications.read-all') }}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(() => fetchNotifications());
        }

        // Search Logic
        const searchInput = document.getElementById('global-search-input');
        const searchResults = document.getElementById('global-search-results');
        let debounceTimer;

        if (searchInput && searchResults) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                clearTimeout(debounceTimer);
                if (query.length < 2) {
                    searchResults.classList.remove('show');
                    return;
                }

                debounceTimer = setTimeout(() => {
                    fetch(`{{ route('crm.global-search') }}?query=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            searchResults.innerHTML = '';
                            if (data && data.length > 0) {
                                data.forEach(item => {
                                    const div = document.createElement('a');
                                    div.href = item.link;
                                    div.className = 'crm-search-item';
                                    div.innerHTML = `
                                        <div class="icon-box"><i class="bi ${item.icon}"></i></div>
                                        <div class="crm-search-item-info">
                                            <span class="crm-search-item-title">${item.title}</span>
                                            <span class="crm-search-item-sub">${item.subtitle}</span>
                                        </div>
                                        <span class="crm-search-item-cat">${item.category}</span>
                                    `;
                                    searchResults.appendChild(div);
                                });
                            } else {
                                searchResults.innerHTML = `<div class="crm-search-no-results">{{ __('لا توجد نتائج مطابقة...') }}</div>`;
                            }
                            searchResults.classList.add('show');
                        })
                        .catch(error => console.error('Error fetching search results:', error));
                }, 300);
            });

            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.remove('show');
                }
            });
        }
    });
    </script>

    {{-- يمين: جرس + لوجو --}}
    <div class="crm-topbar-end">
        <a href="{{ route('lang.switch', app()->getLocale() == 'ar' ? 'en' : 'ar') }}"
           class="crm-topbar-btn crm-lang-toggle d-none d-md-inline-flex"
           rel="prefetch"
           title="{{ app()->getLocale() == 'ar' ? 'Switch to English' : 'التحويل للعربية' }}">
            <i class="bi bi-translate"></i>
            <span class="small fw-bold ms-1">{{ app()->getLocale() == 'ar' ? 'EN' : 'عربي' }}</span>
        </a>
        <div class="dropdown">
            <button class="crm-topbar-btn" id="notif-dropdown-btn" data-bs-toggle="dropdown" aria-expanded="false" title="{{ __('الإشعارات') }}">
                <i class="bi bi-bell"></i>
                <span class="crm-notif-badge d-none" id="notif-badge-dot"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end crm-notif-dropdown p-0 shadow-lg border-0" aria-labelledby="notif-dropdown-btn">
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">{{ __('الإشعارات') }}</h6>
                    <button class="btn btn-link btn-sm p-0 text-decoration-none small" onclick="markAllAsRead()">{{ __('تحديد الكل كمقروء') }}</button>
                </div>
                <div id="notif-items-container" class="notif-scroll-area">
                    {{-- Notifications will be loaded here --}}
                    <div class="p-4 text-center text-muted">
                        <div class="spinner-border spinner-border-sm mb-2" role="status"></div>
                        <div class="small">{{ __('جاري التحميل...') }}</div>
                    </div>
                </div>
                <div class="p-2 border-top text-center">
                    <a href="#" class="small text-decoration-none fw-bold text-muted">{{ __('عرض كل الإشعارات') }}</a>
                </div>
            </div>
        </div>
        <div class="crm-topbar-logo">
            @if($logo)
                <img src="{{ asset('storage/' . $logo) }}" alt="Logo">
            @else
                <span style="font-size:18px;font-weight:900;color:var(--crm-red);">GR</span>
            @endif
        </div>
    </div>

</header>
