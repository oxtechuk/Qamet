@extends('partials.Layouts.crm-master')
@section('title', __('المهام') . ' | GR Motors CRM')

@section('content')
<div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<div class="crm-page-header d-flex align-items-center justify-content-between">
    <div>
        <h1 class="crm-page-title">{{ __('المهام') }}</h1>
        <p class="crm-page-sub">{{ __('إدارة مهام الفريق ومتابعة التنفيذ') }}</p>
    </div>
    @can('manage-tasks')
    <button class="btn-crm-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
        <i class="bi bi-plus-lg"></i> {{ __('مهمة جديدة') }}
    </button>
    @endcan
</div>

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="crm-stat-card">
            <span class="crm-stat-label">{{ __('إجمالي المهام') }}</span>
            <span class="crm-stat-value">{{ $counts['total'] }}</span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="crm-stat-card info">
            <span class="crm-stat-label">{{ __('جديدة') }}</span>
            <span class="crm-stat-value">{{ $counts['new'] }}</span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="crm-stat-card" style="--crm-text:#FF9800">
            <span class="crm-stat-label">{{ __('قيد التنفيذ') }}</span>
            <span class="crm-stat-value" style="color:#FF9800">{{ $counts['in_progress'] }}</span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="crm-stat-card" style="--crm-text:#4CAF50">
            <span class="crm-stat-label">{{ __('مكتملة') }}</span>
            <span class="crm-stat-value" style="color:#4CAF50">{{ $counts['done'] }}</span>
        </div>
    </div>
</div>

{{-- Filter Tabs --}}
<div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="{{ route('crm.tasks.index') }}" class="btn-crm-{{ !$status ? 'primary' : 'light' }}">{{ __('الكل') }}</a>
    <a href="{{ route('crm.tasks.index') }}?status=new" class="btn-crm-{{ $status == 'new' ? 'primary' : 'light' }}">{{ __('جديدة') }}</a>
    <a href="{{ route('crm.tasks.index') }}?status=in_progress" class="btn-crm-{{ $status == 'in_progress' ? 'primary' : 'light' }}">{{ __('قيد التنفيذ') }}</a>
    <a href="{{ route('crm.tasks.index') }}?status=done" class="btn-crm-{{ $status == 'done' ? 'primary' : 'light' }}">{{ __('مكتملة') }}</a>
</div>

{{-- Tasks Grid --}}
<div class="row g-3">
    @forelse($tasks as $task)
    <div class="col-12 col-md-6 col-xl-4">
        <div class="crm-card h-100" style="position:relative; border-right: 4px solid {{ $task->priority == 'high' ? 'var(--crm-red)' : ($task->priority == 'medium' ? '#FF9800' : '#4CAF50') }}">
            {{-- Priority Badge --}}
            <div class="d-flex align-items-start justify-content-between mb-12">
                <span class="badge-{{ $task->priority == 'high' ? 'rejected' : ($task->priority == 'medium' ? 'pending' : 'active') }}">
                    {{ $task->priority_label }}
                </span>
                <span class="badge-{{ $task->status == 'done' ? 'done' : ($task->status == 'in_progress' ? 'pending' : 'new') }}">
                    {{ $task->status_label }}
                </span>
            </div>

            <h6 style="font-weight:800;font-size:15px;color:#1a1a2e;margin-bottom:8px;{{ $task->status == 'done' ? 'text-decoration:line-through;opacity:0.5;' : '' }}">
                {{ $task->title }}
            </h6>

            @if($task->description)
            <p style="font-size:13px;color:#888;margin-bottom:12px;line-height:1.6;">{{ Str::limit($task->description, 80) }}</p>
            @endif

            <div class="d-flex align-items-center gap-2 mt-auto" style="font-size:12px;color:#aaa;border-top:1px solid #f5f5f5;padding-top:12px;margin-top:12px;">
                @if($task->assignedTo)
                    <i class="bi bi-person-circle"></i>
                    <span>{{ $task->assignedTo->name }}</span>
                    <span style="margin:0 4px">·</span>
                @endif
                @if($task->due_date)
                    <i class="bi bi-calendar3"></i>
                    <span style="{{ $task->due_date->isPast() && $task->status != 'done' ? 'color:var(--crm-red);font-weight:700;' : '' }}">
                        {{ $task->due_date->format('d/m/Y') }}
                    </span>
                @endif
                <div class="d-flex gap-1 me-auto">
                    @can('manage-tasks')
                    <form action="{{ route('crm.tasks.toggle', $task) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn-crm-light" style="padding:5px 10px;font-size:11px;" title="{{ __('تغيير الحالة') }}">
                            <i class="bi bi-arrow-repeat"></i>
                        </button>
                    </form>
                    @endcan
                    @can('manage-tasks')
                    <form action="{{ route('crm.tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('{{ __('حذف هذه المهمة؟') }}')">
                        @csrf @method('DELETE')
                        <button class="btn-crm-light" style="padding:5px 10px;font-size:11px;color:var(--crm-red);" title="{{ __('حذف') }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="crm-card text-center py-5">
            <i class="bi bi-check2-square" style="font-size:48px;color:#ddd;display:block;margin-bottom:16px;"></i>
            <p style="color:#aaa;font-weight:700;">{{ __('لا توجد مهام. ابدأ بإضافة أول مهمة!') }}</p>
        </div>
    </div>
    @endforelse
</div>

<div class="mt-4">{{ $tasks->links() }}</div>

{{-- Add Task Modal --}}
<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 rounded-4" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">{{ __('إضافة مهمة جديدة') }}</h5>
                <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('crm.tasks.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('عنوان المهمة') }} <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control rounded-3" required placeholder="{{ __('أدخل عنوان المهمة...') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('الوصف') }}</label>
                        <textarea name="description" class="form-control rounded-3" rows="3" placeholder="{{ __('تفاصيل المهمة...') }}"></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">{{ __('الأولوية') }}</label>
                            <select name="priority" class="form-select rounded-3">
                                <option value="low">{{ __('منخفضة') }}</option>
                                <option value="medium" selected>{{ __('متوسطة') }}</option>
                                <option value="high">{{ __('عالية') }}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">{{ __('الحالة') }}</label>
                            <select name="status" class="form-select rounded-3">
                                <option value="new">{{ __('جديدة') }}</option>
                                <option value="in_progress">{{ __('قيد التنفيذ') }}</option>
                                <option value="done">{{ __('مكتملة') }}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">{{ __('تاريخ الاستحقاق') }}</label>
                            <input type="date" name="due_date" class="form-control rounded-3">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">{{ __('إسناد إلى') }}</label>
                            <select name="assigned_to" class="form-select rounded-3">
                                <option value="">{{ __('— اختر موظفاً —') }}</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn-crm-light" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                    <button type="submit" class="btn-crm-primary">{{ __('إضافة المهمة') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

@endsection
