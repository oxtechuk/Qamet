<div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom flex-wrap" style="border-color:var(--crm-border)!important;">
    @can('manage-settings')
    <a href="{{ route('crm.settings.general') }}"
       class="btn btn-sm rounded-3 fw-bold px-3 py-2 {{ request()->routeIs('crm.settings.general') ? 'text-white' : 'text-muted' }}"
       style="{{ request()->routeIs('crm.settings.general') ? 'background:var(--crm-red);' : 'background:var(--crm-bg);' }}">
        <i class="bi bi-gear me-1"></i> {{ __('العامة') }}
    </a>
    <a href="{{ route('crm.settings.seo') }}"
       class="btn btn-sm rounded-3 fw-bold px-3 py-2 {{ request()->routeIs('crm.settings.seo') ? 'text-white' : 'text-muted' }}"
       style="{{ request()->routeIs('crm.settings.seo') ? 'background:var(--crm-red);' : 'background:var(--crm-bg);' }}">
        <i class="bi bi-search-heart me-1"></i> {{ __('SEO والتحليلات') }}
    </a>
    @endcan
    @can('manage-settings-integrations')
    <a href="{{ route('crm.settings.integrations') }}"
       class="btn btn-sm rounded-3 fw-bold px-3 py-2 {{ request()->routeIs('crm.settings.integrations') ? 'text-white' : 'text-muted' }}"
       style="{{ request()->routeIs('crm.settings.integrations') ? 'background:var(--crm-red);' : 'background:var(--crm-bg);' }}">
        <i class="bi bi-plugin me-1"></i> {{ __('الربط والإشعارات') }}
    </a>
    @endcan
</div>
