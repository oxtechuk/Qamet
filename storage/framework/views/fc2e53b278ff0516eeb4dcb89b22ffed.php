<!DOCTYPE html>
<html lang="<?php echo e(App::getLocale()); ?>" dir="<?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('تسجيل دخول المديرين | Konz')); ?></title>

    <?php echo \Filament\Support\Facades\FilamentAsset::renderStyles() ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #299BE0;
            --primary-dark: #1a7cb5;
            --primary-glow: rgba(41, 155, 224, 0.15);
            --bg-light: #ffffff;
            --bg-gray: #f8fafc;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #cbd5e1;
            --success: #10b981;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Cairo', sans-serif; }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            display: flex;
            width: 100vw;
            height: 100vh;
            flex-direction: row;
        }

        .image-panel {
            flex: 1.4;
            position: relative;
            background-image: url('<?php echo e(asset("images/home_hero.png")); ?>');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 60px;
            color: #ffffff;
        }

        .image-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(13, 16, 24, 0.85) 0%, rgba(41, 155, 224, 0.2) 100%);
            z-index: 1;
        }

        .image-panel-content {
            position: relative;
            z-index: 2;
            max-width: 550px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .image-panel-content h2 {
            font-size: 34px;
            font-weight: 800;
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .image-panel-content p {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 500;
            line-height: 1.6;
        }

        .form-panel {
            width: 480px;
            background-color: var(--bg-light);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 60px 48px;
            overflow-y: auto;
            position: relative;
            box-shadow: -10px 0 30px rgba(0,0,0,0.02);
            border-left: 1px solid #f1f5f9;
        }

        .form-content-wrapper {
            margin-top: auto;
            margin-bottom: auto;
            width: 100%;
        }

        .logo-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 40px;
        }

        .logo-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 12px;
            padding: 6px 16px;
            background: rgba(41, 155, 224, 0.08);
            border: 1px solid rgba(41, 155, 224, 0.15);
            border-radius: 50px;
            font-size: 12px;
            color: var(--primary);
            font-weight: 700;
        }

        .form-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .form-header h1 {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-header p {
            color: var(--text-muted);
            font-size: 14px;
        }

        .footer-text {
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 30px;
        }

        .footer-text a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }

        /* ============ Filament Overrides ============ */
        .fi-simple-page,
        .fi-simple-page-content {
            all: unset !important;
            display: block !important;
        }

        .fi-simple-layout,
        .fi-simple-main-ctn,
        .fi-simple-main {
            all: unset !important;
            display: block !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        .fi-simple-header {
            display: none !important;
        }

        /* Field wrapper */
        .fi-fo-field {
            margin-bottom: 20px;
        }

        /* Label */
        .fi-fo-field-label label,
        .fi-fo-field-label-content {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        /* Input wrapper */
        .fi-input-wrp {
            width: 100%;
            background: var(--bg-gray);
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .fi-input-wrp:focus-within {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(41, 155, 224, 0.15);
        }

        /* Input element */
        .fi-input {
            width: 100%;
            height: 50px;
            padding: 0 16px;
            background: transparent;
            border: none;
            color: var(--text-dark);
            font-size: 15px;
            outline: none;
            font-family: 'Cairo', sans-serif;
        }

        .fi-input::placeholder {
            color: var(--text-muted);
            opacity: 0.7;
        }

        /* Checkbox */
        .fi-fo-checkbox {
            accent-color: var(--primary);
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .fi-fo-checkbox-label {
            font-size: 13px;
            color: var(--text-muted);
            cursor: pointer;
            user-select: none;
        }

        /* Error messages */
        .fi-fo-field-wrp-error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
        }

        /* Form */
        .fi-simple-page form {
            width: 100%;
        }

        /* Submit button */
        .fi-simple-page form > button[type="submit"],
        .fi-simple-page form .fi-btn {
            width: 100% !important;
            height: 52px !important;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
            color: #fff !important;
            border: none !important;
            border-radius: 12px !important;
            font-size: 16px !important;
            font-weight: 800 !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 10px !important;
            box-shadow: 0 10px 25px rgba(41, 155, 224, 0.25) !important;
            font-family: 'Cairo', sans-serif !important;
            margin-top: 8px !important;
            padding: 0 24px !important;
        }

        .fi-simple-page form > button[type="submit"]:hover,
        .fi-simple-page form .fi-btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 15px 30px rgba(41, 155, 224, 0.35) !important;
        }

        .fi-simple-page form > button[type="submit"]:active,
        .fi-simple-page form .fi-btn:active {
            transform: translateY(0) !important;
        }

        .fi-simple-page form > button[type="submit"]:disabled,
        .fi-simple-page form .fi-btn:disabled {
            opacity: 0.7 !important;
            cursor: not-allowed !important;
            transform: none !important;
        }

        /* RTL */
        [dir="rtl"] .fi-input { text-align: right; }
        [dir="rtl"] .fi-fo-field-label label { text-align: right; }
        [dir="ltr"] .fi-input { text-align: left; }
        [dir="ltr"] .fi-fo-field-label label { text-align: left; }

        @media (max-width: 900px) {
            .image-panel { display: none; }
            .form-panel {
                width: 100%;
                max-width: 500px;
                margin: auto;
                height: 100vh;
                box-shadow: none;
                border: none;
                padding: 40px 24px;
            }
        }
    </style>
</head>
<body>
    <?php echo e($slot); ?>

    <?php echo \Filament\Support\Facades\FilamentAsset::renderScripts() ?>
</body>
</html>
<?php /**PATH D:\Projects\XO\kma\resources\views/filament/layouts/auth.blade.php ENDPATH**/ ?>