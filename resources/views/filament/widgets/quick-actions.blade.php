<x-filament-widgets::widget>
    <x-filament::section
        :heading="__('Quick Actions')"
        :description="__('Common tasks to get started')"
        icon="heroicon-m-bolt"
    >
        <div class="quick-actions-grid">
            <a href="{{ route('filament.admin.resources.cars.create') }}" class="quick-action-card">
                <div class="quick-action-icon" style="background: #eef2ff; color: #6366f1;">
                    <x-filament::icon icon="heroicon-m-truck" class="w-5 h-5" />
                </div>
                <span class="quick-action-label">{{ __('Add Car') }}</span>
            </a>

            <a href="{{ route('filament.admin.resources.brands.create') }}" class="quick-action-card">
                <div class="quick-action-icon" style="background: #f0fdf4; color: #22c55e;">
                    <x-filament::icon icon="heroicon-m-tag" class="w-5 h-5" />
                </div>
                <span class="quick-action-label">{{ __('Add Brand') }}</span>
            </a>

            <a href="{{ route('filament.admin.resources.bookings.create') }}" class="quick-action-card">
                <div class="quick-action-icon" style="background: #fefce8; color: #eab308;">
                    <x-filament::icon icon="heroicon-m-shopping-cart" class="w-5 h-5" />
                </div>
                <span class="quick-action-label">{{ __('New Order') }}</span>
            </a>

            <a href="{{ route('filament.admin.resources.leads.create') }}" class="quick-action-card">
                <div class="quick-action-icon" style="background: #f5f3ff; color: #a855f7;">
                    <x-filament::icon icon="heroicon-m-users" class="w-5 h-5" />
                </div>
                <span class="quick-action-label">{{ __('Add Lead') }}</span>
            </a>

            <a href="{{ route('filament.admin.resources.offers.create') }}" class="quick-action-card">
                <div class="quick-action-icon" style="background: #fff7ed; color: #f97316;">
                    <x-filament::icon icon="heroicon-m-document-text" class="w-5 h-5" />
                </div>
                <span class="quick-action-label">{{ __('Create Offer') }}</span>
            </a>

            <a href="{{ route('filament.admin.resources.employees.create') }}" class="quick-action-card">
                <div class="quick-action-icon" style="background: #ecfeff; color: #06b6d4;">
                    <x-filament::icon icon="heroicon-m-building-storefront" class="w-5 h-5" />
                </div>
                <span class="quick-action-label">{{ __('Add Staff') }}</span>
            </a>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
