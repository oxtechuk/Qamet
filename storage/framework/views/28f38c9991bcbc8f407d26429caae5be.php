<div class="login-container" dir="<?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>">

    <div class="image-panel">
        <div class="image-panel-content">
            <h2><?php echo e(__('منصة إدارة وتتبع السيارات الأكثر تميزاً')); ?></h2>
            <p><?php echo e(__('تحكم في أسطول سياراتك، تتبع الحجوزات والمبيعات، وقم بإدارة لوحة العمل الخاصة بك بكل سهولة وذكاء.')); ?></p>
        </div>
    </div>

    <div class="form-panel">
        <div class="form-content-wrapper">
            <div class="logo-section">
                <img src="<?php echo e(asset('images/logo_without_bg.png')); ?>" alt="Konz Logo" style="max-height: 75px; width: auto; filter: drop-shadow(0 4px 10px rgba(41, 155, 224, 0.15));">
                <div class="logo-badge">
                    <i class="bi bi-shield-check"></i>
                    <?php echo e(__('لوحة تحكم المديرين')); ?>

                </div>
            </div>

            <div class="form-header">
                <h1><?php echo e(__('مرحباً بعودتك')); ?></h1>
                <p><?php echo e(__('قم بتسجيل الدخول للمتابعة إلى لوحة التحكم')); ?></p>
            </div>

            <?php echo e($this->content); ?>

        </div>

        <div class="footer-text">
            &copy; <?php echo e(date('Y')); ?> <a href="<?php echo e(route('store.home')); ?>">Konz</a> Dashboard. All rights reserved.
        </div>
    </div>

</div>
<?php /**PATH D:\Projects\XO\kma\resources\views/filament/pages/auth/login.blade.php ENDPATH**/ ?>