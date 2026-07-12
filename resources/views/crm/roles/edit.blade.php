@extends('partials.Layouts.crm-master')
@section('title', __('تعديل دور') . ' | AutoCRM')

@section('content')
<div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold"> {{ __('تعديل دور') }}: {{ $role->name }}</h4>
            <p class="text-muted mb-0 small">{{ __('قم بتعديل بيانات الدور والصلاحيات المرتبطة به') }}</p>
        </div>
        <div>
            <a href="{{ route('crm.roles.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm fw-bold">
                <i class="bi bi-arrow-right me-1"></i> {{ __('العودة') }}
            </a>
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
        <div class="card-body p-4">
            <form action="{{ route('crm.roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="form-label fw-bold">{{ __('اسم الدور') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control form-control-lg bg-light border-0" value="{{ old('name', $role->name) }}" required placeholder="{{ __('أدخل اسم الدور') }}">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold mb-3 d-block">{{ __('الصلاحيات المتاحة') }}</label>
                    
                    <div class="row g-3">
                        @foreach($permissions as $permission)
                        <div class="col-md-3 col-sm-6">
                            <div class="form-check form-switch p-3 border rounded-3 bg-light">
                                <input class="form-check-input float-end ms-0 me-2" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}" {{ in_array($permission->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold small ms-5" for="perm_{{ $permission->id }}">
                                    {{ __('permissions.' . $permission->name) !== 'permissions.' . $permission->name ? __('permissions.' . $permission->name) : $permission->name }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    @can('manage-roles')
                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 shadow-sm fw-bold">
                        <i class="bi bi-check2-circle me-1"></i> {{ __('تحديث الدور') }}
                    </button>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-check-input:checked {
        background-color: rgba(235, 94, 40, 1);
        border-color: rgba(235, 94, 40, 1);
    }
    .form-check-label {
        padding-right: 2.5rem; /* For RTL */
    }
    html[dir="ltr"] .form-check-label {
        padding-right: 0;
        padding-left: 2.5rem;
    }
    html[dir="rtl"] .form-check-input.float-end {
        float: left !important;
        margin-left: 0 !important;
        margin-right: .5rem !important;
    }
</style>
@endsection
