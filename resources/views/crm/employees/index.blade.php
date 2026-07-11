@extends('partials.Layouts.crm-master')
@section('title', __('إدارة الموظفين') . ' | AutoCRM')

@section('content')
<div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold"> {{ __('إدارة فريق العمل') }}</h4>
            <p class="text-muted mb-0 small">{{ __('إجمالي') }} {{ $employees->total() }} {{ __('موظف مسجل في النظام') }}</p>
        </div>
        @can('manage-employees')
        <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
            <i class="bi bi-person-plus-fill me-1"></i> {{ __('إضافة موظف جديد') }}
        </button>
        @endcan
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
                        <th class="px-4 py-3 text-muted fw-bold small text-uppercase">{{ __('الموظف') }}</th>
                        <th class="py-3 text-muted fw-bold small text-uppercase">{{ __('بيانات التواصل') }}</th>
                        <th class="py-3 text-muted fw-bold small text-uppercase text-center">{{ __('الصلاحية') }}</th>
                        <th class="py-3 text-muted fw-bold small text-uppercase text-center">{{ __('الطلبات المستلمة') }}</th>
                        <th class="py-3 text-muted fw-bold small text-uppercase text-center">{{ __('الحالة') }}</th>
                        <th class="py-3 text-end px-4"></th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($employees as $emp)
                    <tr>
                        <td class="px-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-md bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-xs" style="width: 40px; height: 40px;">
                                    {{ mb_substr($emp->name, 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">{{ $emp->name }}</h6>
                                    <small class="text-muted">@<span>{{ $emp->username ?? 'user' }}</span></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1 small fw-medium text-muted">
                                <span dir="ltr" class="text-start"><i class="bi bi-envelope me-1"></i> {{ $emp->email }}</span>
                                @if($emp->phone)
                                <span dir="ltr" class="text-start"><i class="bi bi-telephone me-1"></i> {{ $emp->phone }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            @if($emp->role === 'admin')
                                <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill small fw-bold">{{ __('مدير نظام') }}</span>
                            @elseif($emp->role === 'sales')
                                <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill small fw-bold">{{ __('مبيعات') }}</span>
                            @elseif($emp->role === 'sales-rep')
                                <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill small fw-bold">{{ __('مندوب مبيعات') }}</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill small fw-bold">{{ __($emp->role) }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-3 small fw-bold">
                                {{ $emp->bookings_count ?? 0 }} {{ __('طلب') }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($emp->is_active)
                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill small fw-bold">{{ __('نشط') }}</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill small fw-bold">{{ __('موقوف') }}</span>
                            @endif
                        </td>
                        <td class="text-end px-4">
                            <div class="d-flex gap-2 justify-content-end">
                                @can('manage-employees')
                                <button class="btn btn-sm btn-white border shadow-xs rounded-2" data-bs-toggle="modal" data-bs-target="#editEmployeeModal{{ $emp->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                @endcan
                                @can('manage-employees')
                                <form action="{{ route('crm.employees.destroy', $emp) }}" method="POST" onsubmit="return confirm('{{ __("هل أنت متأكد من حذف هذا الموظف؟") }}')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger-subtle text-danger rounded-2 shadow-xs"><i class="bi bi-trash"></i></button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>

                    {{-- Modal التعديل --}}
                    <div class="modal fade" id="editEmployeeModal{{ $emp->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                                <div class="modal-header border-0 pt-4 px-4">
                                    <h5 class="modal-title fw-bold">{{ __('تعديل بيانات الموظف') }}</h5>
                                    <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('crm.employees.update', $emp) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-body p-4 pt-2">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-muted">{{ __('الاسم بالكامل') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control bg-light border-0 shadow-none" value="{{ $emp->name }}" required>
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold small text-muted">{{ __('البريد الإلكتروني') }} <span class="text-danger">*</span></label>
                                                <input type="email" name="email" class="form-control bg-light border-0 shadow-none" value="{{ $emp->email }}" required dir="ltr">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold small text-muted">{{ __('رقم الهاتف') }}</label>
                                                <input type="text" name="phone" class="form-control bg-light border-0 shadow-none" value="{{ $emp->phone }}" dir="ltr">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold small text-muted">{{ __('الصلاحية (Role)') }} <span class="text-danger">*</span></label>
                                            <select name="role" class="form-select bg-light border-0 shadow-none" required>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->name }}" {{ $emp->role === $role->name ? 'selected' : '' }}>
                                                        {{ $role->name === 'admin' ? __('مدير نظام (Admin)') : ($role->name === 'sales' ? __('فريق المبيعات') : ($role->name === 'sales-rep' ? __('مندوب مبيعات (Sales Rep)') : __($role->name))) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label fw-bold small text-muted">{{ __('كلمة المرور الجديدة') }}</label>
                                            <input type="password" name="password" class="form-control bg-light border-0 shadow-none" placeholder="{{ __('اتركه فارغاً للاحتفاظ بالكلمة الحالية') }}" minlength="6" dir="ltr">
                                        </div>
                                        <div class="form-check form-switch p-3 bg-light rounded-3">
                                            <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-0 me-2 float-none' : '' }}" type="checkbox" name="is_active" value="1" id="active{{ $emp->id }}" {{ $emp->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold ms-2" for="active{{ $emp->id }}">{{ __('حساب الموظف نشط') }}</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 p-4 pt-0">
                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">{{ __('حفظ التغييرات') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="opacity-25 mb-3">
                                <i class="bi bi-people" style="font-size: 4rem;"></i>
                            </div>
                            <h6 class="fw-bold">{{ __('لا يوجد موظفين مسجلين حالياً') }}</h6>
                            <p class="small text-muted">{{ __('ابدأ ببناء فريق عملك وإضافة الموظفين المسؤولين عن المبيعات') }}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($employees->hasPages())
        <div class="card-footer bg-white border-top-0 p-4">
            {{ $employees->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Modal الإضافة --}}
<div class="modal fade" id="addEmployeeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">{{ __('إضافة موظف جديد للفريق') }}</h5>
                <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('crm.employees.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 pt-2">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">{{ __('الاسم بالكامل') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control bg-light border-0 shadow-none" placeholder="{{ __('مثال: أحمد محمد') }}" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">{{ __('البريد الإلكتروني') }} <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control bg-light border-0 shadow-none" placeholder="name@domain.com" required dir="ltr">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">{{ __('رقم الهاتف') }}</label>
                            <input type="text" name="phone" class="form-control bg-light border-0 shadow-none" placeholder="01xxxxxxxxx" dir="ltr">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">{{ __('الصلاحية') }} <span class="text-danger">*</span></label>
                        <select name="role" class="form-select bg-light border-0 shadow-none" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">
                                    {{ $role->name === 'admin' ? __('مدير نظام (Admin)') : ($role->name === 'sales' ? __('فريق المبيعات') : ($role->name === 'sales-rep' ? __('مندوب مبيعات (Sales Rep)') : __($role->name))) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">{{ __('كلمة المرور') }} <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control bg-light border-0 shadow-none" required minlength="6" dir="ltr" placeholder="••••••••">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">{{ __('إضافة الموظف الآن') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-white { background: #fff; }
    .btn-danger-subtle { background: #ffebee; border: none; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .bg-primary-subtle { background: #e7f1ff; }
</style>
@endsection
