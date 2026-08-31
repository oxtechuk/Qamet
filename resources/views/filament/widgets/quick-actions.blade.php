@php
    $user = \Illuminate\Support\Facades\Auth::guard('employee')->user();
@endphp

@if ($user)
    @php
        $canBookings = $user->isAdmin() || $user->hasPermission(['manage-bookings', 'manage-cash-bookings', 'manage-finance-bookings', 'manage-corporate-bookings']);
        $canLeads = $user->isAdmin() || $user->hasPermission('manage-leads');
        $canCars = $user->isAdmin() || $user->hasPermission('manage-cars');
        $canBrands = $user->isAdmin() || $user->hasPermission('manage-brands');
        $canOffers = $user->isAdmin() || $user->hasPermission('manage-offers');
        $canTasks = $user->isAdmin() || $user->hasPermission('manage-tasks');
        $canEmployees = $user->isAdmin() || $user->hasPermission('manage-employees');
        $hasAnyAction = $canBookings || $canLeads || $canCars || $canBrands || $canOffers || $canTasks || $canEmployees;
    @endphp

    @if ($hasAnyAction)
        <x-filament-widgets::widget>
            <x-filament::section
                :heading="__('Quick Actions')"
                :description="__('مهام سريعة لبدء العمل المباشر')"
                icon="heroicon-m-bolt"
            >
                <div class="quick-actions-grid">
                    @if ($canBookings)
                        <a href="{{ route('filament.admin.resources.bookings.create') }}" class="quick-action-card">
                            <div class="quick-action-icon" style="background: #fefce8; color: #eab308;">
                                <x-filament::icon icon="heroicon-m-shopping-cart" class="w-5 h-5" />
                            </div>
                            <span class="quick-action-label">{{ __('طلب جديد') }}</span>
                        </a>
                    @endif

                    @if ($canLeads)
                        <a href="{{ route('filament.admin.resources.leads.create') }}" class="quick-action-card">
                            <div class="quick-action-icon" style="background: #f5f3ff; color: #a855f7;">
                                <x-filament::icon icon="heroicon-m-user-plus" class="w-5 h-5" />
                            </div>
                            <span class="quick-action-label">{{ __('إضافة عميل محتمل') }}</span>
                        </a>
                    @endif

                    @if ($canTasks)
                        <a href="{{ route('filament.admin.resources.tasks.create') }}" class="quick-action-card">
                            <div class="quick-action-icon" style="background: #eff6ff; color: #3b82f6;">
                                <x-filament::icon icon="heroicon-m-clipboard-document-check" class="w-5 h-5" />
                            </div>
                            <span class="quick-action-label">{{ __('إضافة مهمة') }}</span>
                        </a>
                    @endif

                    @if ($canCars)
                        <a href="{{ route('filament.admin.resources.cars.create') }}" class="quick-action-card">
                            <div class="quick-action-icon" style="background: #eef2ff; color: #6366f1;">
                                <x-filament::icon icon="heroicon-m-truck" class="w-5 h-5" />
                            </div>
                            <span class="quick-action-label">{{ __('إضافة سيارة') }}</span>
                        </a>
                    @endif

                    @if ($canBrands)
                        <a href="{{ route('filament.admin.resources.brands.create') }}" class="quick-action-card">
                            <div class="quick-action-icon" style="background: #f0fdf4; color: #22c55e;">
                                <x-filament::icon icon="heroicon-m-tag" class="w-5 h-5" />
                            </div>
                            <span class="quick-action-label">{{ __('إضافة ماركة') }}</span>
                        </a>
                    @endif

                    @if ($canOffers)
                        <a href="{{ route('filament.admin.resources.offers.create') }}" class="quick-action-card">
                            <div class="quick-action-icon" style="background: #fff7ed; color: #f97316;">
                                <x-filament::icon icon="heroicon-m-document-text" class="w-5 h-5" />
                            </div>
                            <span class="quick-action-label">{{ __('إنشاء عرض') }}</span>
                        </a>
                    @endif

                    @if ($canEmployees)
                        <a href="{{ route('filament.admin.resources.employees.create') }}" class="quick-action-card">
                            <div class="quick-action-icon" style="background: #ecfeff; color: #06b6d4;">
                                <x-filament::icon icon="heroicon-m-building-storefront" class="w-5 h-5" />
                            </div>
                            <span class="quick-action-label">{{ __('إضافة موظف') }}</span>
                        </a>
                    @endif
                </div>
            </x-filament::section>
        </x-filament-widgets::widget>
    @endif
@endif
