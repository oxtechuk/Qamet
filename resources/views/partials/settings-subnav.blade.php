<div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom flex-wrap" style="border-color:var(--crm-border-light)!important;">
    @can('manage-settings')
    <a href="{{ route('crm.settings.general') }}"
       class="crm-filter-tab {{ request()->routeIs('crm.settings.general') ? 'active' : '' }}">
        <i class="bi bi-gear"></i> {{ __('العامة') }}
    </a>
    <a href="{{ route('crm.settings.seo') }}"
       class="crm-filter-tab {{ request()->routeIs('crm.settings.seo') ? 'active' : '' }}">
        <i class="bi bi-search-heart"></i> {{ __('SEO والتحليلات') }}
    </a>
    <a href="{{ route('crm.settings.maintenance') }}"
       class="crm-filter-tab {{ request()->routeIs('crm.settings.maintenance') ? 'active' : '' }}">
        <i class="bi bi-shield-exclamation"></i> {{ __('الصيانة') }}
    </a>
    @endcan
    @can('manage-settings-integrations')
    <a href="{{ route('crm.settings.integrations') }}"
       class="crm-filter-tab {{ request()->routeIs('crm.settings.integrations') ? 'active' : '' }}">
        <i class="bi bi-plugin"></i> {{ __('الربط والإشعارات') }}
    </a>
    @endcan
</div>
