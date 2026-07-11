@extends('partials.Layouts.crm-master')
@section('title', __('إدارة الصلاحيات والأدوار') . ' | AutoCRM')

@section('content')
<div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold">🛡️ {{ __('إدارة الصلاحيات والأدوار') }}</h4>
            <p class="text-muted mb-0 small">{{ __('إجمالي') }} {{ $roles->total() }} {{ __('دور مسجل في النظام') }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('crm.employees.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm fw-bold">
                <i class="bi bi-arrow-right me-1"></i> {{ __('العودة للموظفين') }}
            </a>
            @can('manage-roles')
            <a href="{{ route('crm.roles.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                <i class="bi bi-shield-plus me-1"></i> {{ __('إضافة دور جديد') }}
            </a>
            @endcan
        </div>
    </div>

   
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4">
        <ul class="mb-0 small fw-bold">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-muted fw-bold small text-uppercase">{{ __('اسم الدور') }}</th>
                        <th class="py-3 text-muted fw-bold small text-uppercase text-center">{{ __('عدد الموظفين') }}</th>
                        <th class="py-3 text-muted fw-bold small text-uppercase text-center">{{ __('عدد الصلاحيات') }}</th>
                        <th class="py-3 text-end px-4"></th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($roles as $role)
                    <tr>
                        <td class="px-4">
                            <h6 class="mb-0 fw-bold text-dark">{{ $role->name }}</h6>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill small fw-bold">
                                {{ $role->users_count }} {{ __('موظف') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-3 small fw-bold">
                                {{ $role->permissions->count() }} {{ __('صلاحية') }}
                            </span>
                        </td>
                        <td class="text-end px-4">
                            <div class="d-flex gap-2 justify-content-end">
                                @can('manage-roles')
                                <a href="{{ route('crm.roles.edit', $role) }}" class="btn btn-sm btn-white border shadow-xs rounded-2">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @endcan
                                @can('manage-roles')
                                @if($role->name !== 'admin')
                                <form action="{{ route('crm.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('{{ __("هل أنت متأكد من حذف هذا الدور؟") }}')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger-subtle text-danger rounded-2 shadow-xs"><i class="bi bi-trash"></i></button>
                                </form>
                                @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="opacity-25 mb-3">
                                <i class="bi bi-shield-lock" style="font-size: 4rem;"></i>
                            </div>
                            <h6 class="fw-bold">{{ __('لا يوجد أدوار مسجلة حالياً') }}</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($roles->hasPages())
        <div class="card-footer bg-white border-top-0 p-4">
            {{ $roles->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .btn-white { background: #fff; }
    .btn-danger-subtle { background: #ffebee; border: none; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .bg-primary-subtle { background: #e7f1ff; }
</style>
@endsection
