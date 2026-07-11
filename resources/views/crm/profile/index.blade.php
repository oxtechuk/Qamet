@extends('partials.Layouts.crm-master')

@section('title', __('الملف الشخصي') . ' | ' . $user->name)

@section('content')
<div class="container-fluid">
    <div class="crm-page-header">
        <h1 class="crm-page-title">{{ __('إعدادات الملف الشخصي') }}</h1>
        <p class="crm-page-sub">{{ __('قم بتحديث بياناتك الشخصية وصورتك من هنا') }}</p>
    </div>

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="crm-card text-center mb-4">
                <div class="position-relative d-inline-block mb-3">
                    <div class="crm-user-avatar shadow-sm" style="width: 120px; height: 120px; font-size: 40px; border: 4px solid #fff;">
                        @if($user->avatar)
                            <img src="{{ asset('storage/'.$user->avatar) }}" id="avatar-preview" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div id="avatar-placeholder" class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-danger fw-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <img src="" id="avatar-preview" class="d-none" style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>
                    <label for="avatar-input" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle p-2 shadow" style="width: 35px; height: 35px; cursor: pointer;">
                        <i class="bi bi-camera"></i>
                    </label>
                </div>
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-3">{{ $user->role === 'admin' ? __('مدير النظام') : ($user->role === 'sales-rep' ? __('مندوب مبيعات') : ($user->role === 'sales' ? __('موظف مبيعات') : __($user->role))) }}</p>
                <div class="d-flex justify-content-center gap-2">
                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }} rounded-pill px-3">
                        {{ $user->is_active ? __('نشط') : __('غير نشط') }}
                    </span>
                </div>
            </div>

            <div class="crm-card">
                <h6 class="fw-bold mb-3"><i class="bi bi-shield-lock me-2 text-primary"></i>{{ __('أمان الحساب') }}</h6>
                <p class="text-muted small mb-0">{{ __('تم تسجيل دخولك كـ') }}: <span class="fw-bold text-dark">{{ $user->username }}</span></p>
                <hr class="my-3 opacity-50">
                <p class="text-muted small">{{ __('تأكد من استخدام كلمة مرور قوية وفريدة لحماية حسابك من الاختراق.') }}</p>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <form action="{{ route('crm.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="file" name="avatar" id="avatar-input" class="d-none" accept="image/*" onchange="previewAvatar(this)">

                <div class="crm-card mb-4">
                    <h5 class="crm-card-title">{{ __('البيانات الأساسية') }}</h5>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('الاسم الكامل') }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('البريد الإلكتروني') }}</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('رقم الهاتف') }}</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('اسم المستخدم') }}</label>
                            <input type="text" class="form-control" value="{{ $user->username }}" disabled>
                            <small class="text-muted">{{ __('لا يمكن تغيير اسم المستخدم') }}</small>
                        </div>
                    </div>
                </div>

                <div class="crm-card mb-4">
                    <h5 class="crm-card-title">{{ __('تغيير كلمة المرور') }}</h5>
                    <p class="text-muted small mb-4">{{ __('اترك الحقول فارغة إذا كنت لا ترغب في تغيير كلمة المرور الحالية') }}</p>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('كلمة المرور الجديدة') }}</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('تأكيد كلمة المرور') }}</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <button type="reset" class="btn btn-crm-light px-4">{{ __('إعادة تعيين') }}</button>
                    <button type="submit" class="btn btn-crm-primary px-5">{{ __('حفظ التغييرات') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-placeholder');
            
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            if(placeholder) placeholder.classList.add('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
