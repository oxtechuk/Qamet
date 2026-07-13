<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم | GR Motors')</title>

    {{-- Preconnect & DNS-Prefetch for Speed --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    {{-- Dynamic Bootstrap (Fixed Paths & Localized) --}}
    @if(App::getLocale() == 'ar')
        <link href="{{ asset('assets/libs/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
        {{-- Preload English assets in background --}}
        <link rel="prefetch" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
    @else
        <link href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        {{-- Preload Arabic assets in background --}}
        <link rel="prefetch" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap">
    @endif
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @yield('css')

    <style>
        :root {
            /* Brand — Warm Professional amber/stone palette */
            --crm-primary: #B45309;
            --crm-primary-hover: #92400E;
            --crm-primary-light: rgba(180, 83, 9, 0.07);
            --crm-primary-ring: rgba(180, 83, 9, 0.14);
            --crm-primary-gradient: linear-gradient(135deg, #B45309 0%, #D97706 100%);
            --crm-primary-glow: 0 12px 24px -6px rgba(180, 83, 9, 0.30);

            /* Legacy aliases */
            --crm-red: var(--crm-primary);
            --crm-red-dark: var(--crm-primary-hover);
            --crm-red-light: var(--crm-primary-light);

            /* Semantic */
            --crm-success: #059669;
            --crm-warning: #D97706;
            --crm-danger: #E11D48;
            --crm-green: #059669;
            --crm-orange: #D97706;
            --crm-blue: #0284C7;
            --crm-purple: #7C3AED;
            --crm-teal: #0D9488;

            /* Layout */
            --crm-sidebar-width: 252px;
            --crm-topbar-height: 64px;

            /* Surfaces & text — warm stone tones */
            --crm-bg: #FAF9F7;
            --crm-surface: #F5F3F0;
            --crm-surface-hover: #EDEBE7;
            --crm-card-bg: #fff;
            --crm-text: #1C1917;
            --crm-text-secondary: #57534E;
            --crm-text-muted: #78716C;
            --crm-border: #E7E5E4;
            --crm-border-light: #F5F5F4;

            /* Elevation */
            --crm-radius: 14px;
            --crm-radius-sm: 10px;
            --crm-radius-xs: 8px;
            --crm-shadow-xs: 0 1px 2px rgba(28, 25, 23, 0.04);
            --crm-shadow: 0 1px 3px rgba(28, 25, 23, 0.04), 0 4px 12px rgba(28, 25, 23, 0.06);
            --crm-shadow-md: 0 4px 16px rgba(28, 25, 23, 0.08);
            --crm-shadow-lg: 0 8px 32px rgba(28, 25, 23, 0.12);
        }

        .gr-currency {
            display: inline-block !important;
            width: 18px !important;
            height: 18px !important;
            background-color: currentColor;
            -webkit-mask-image: url('{{ asset('assets/images/Saudi_Riyal_Symbol.svg.png') }}') !important;
            mask-image: url('{{ asset('assets/images/Saudi_Riyal_Symbol.svg.png') }}') !important;
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-position: center;
            mask-position: center;
            -webkit-mask-size: contain;
            mask-size: contain;
            vertical-align: middle;
            margin: 0 2px;
        }

        .text-danger .gr-currency,
        .text-decoration-line-through .gr-currency {
            color: var(--crm-danger) !important;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body.crm-shell {
            font-family: {{ App::getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Inter', sans-serif" }};
            background: var(--crm-bg);
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: row;
            color: var(--crm-text);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            opacity: 0;
            animation: fadeInBody 0.35s ease-out forwards;
        }

        @keyframes fadeInBody {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== SIDEBAR ===== */
        .crm-sidebar {
            width: var(--crm-sidebar-width);
            min-height: 100vh;
            background: #FFFFFF;
            border-{{ App::getLocale() == 'ar' ? 'left' : 'right' }}: 1px solid var(--crm-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            {{ App::getLocale() == 'ar' ? 'right: 0;' : 'left: 0;' }}
            top: 0;
            bottom: 0;
            z-index: 1000;
            overflow-y: auto;
            scrollbar-width: none;
        }
        .crm-sidebar::-webkit-scrollbar { display: none; }

        .crm-sidebar-logo {
            background: #fff;
            padding: 20px 20px;
            border-bottom: 1px solid var(--crm-border-light);
            text-align: center;
        }
        .crm-sidebar-logo img { max-height: 38px; }
        .crm-sidebar-brand { color: var(--crm-text); font-weight: 800; font-size: 15px; line-height: 1.2; margin-top: 8px; }
        .crm-sidebar-brand small { color: var(--crm-text-muted); font-size: 10px; font-weight: 600; display: block; letter-spacing: 1px; }

        .crm-nav { flex: 1; padding: 12px 0; background: #fff; }
        .crm-nav-section { padding: 0 12px; margin-bottom: 2px; }
        .crm-nav-label { color: var(--crm-text-muted); font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; padding: 16px 10px 6px; display: block; }

        .crm-nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: var(--crm-radius-sm);
            color: var(--crm-text-secondary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.15s ease;
            margin-bottom: 1px;
            white-space: nowrap;
            overflow: hidden;
            position: relative;
        }
        .crm-nav-link i { font-size: 16px; width: 18px; text-align: center; flex-shrink: 0; opacity: 0.7; }
        .crm-nav-link:hover { background: var(--crm-primary-light); color: var(--crm-primary); }
        .crm-nav-link:hover i { opacity: 1; }
        .crm-nav-link.active {
            background: var(--crm-primary-light);
            color: var(--crm-primary);
            font-weight: 700;
        }
        .crm-nav-link.active i { opacity: 1; }
        a.crm-nav-link.active::after {
            content: '';
            position: absolute;
            top: 6px;
            bottom: 6px;
            {{ App::getLocale() == 'ar' ? 'right: 0;' : 'left: 0;' }}
            width: 3px;
            background: var(--crm-primary);
            border-radius: 3px;
        }
        .crm-nav-link .nav-badge {
            margin-{{ App::getLocale() == 'ar' ? 'right' : 'left' }}: auto;
            background: var(--crm-danger); color: #fff;
            border-radius: 10px; font-size: 10px; font-weight: 800; padding: 1px 7px;
            min-width: 20px; text-align: center;
        }

        .crm-sidebar-footer {
            padding: 12px 12px 16px;
            border-top: 1px solid var(--crm-border-light);
        }

        /* ===== MAIN AREA ===== */
        .crm-main {
            {{ App::getLocale() == 'ar' ? 'margin-right: var(--crm-sidebar-width);' : 'margin-left: var(--crm-sidebar-width);' }}
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ===== TOPBAR ===== */
        .crm-topbar {
            height: var(--crm-topbar-height);
            background: rgba(250, 249, 247, 0.82);
            backdrop-filter: blur(16px) saturate(1.4);
            -webkit-backdrop-filter: blur(16px) saturate(1.4);
            border-bottom: 1px solid var(--crm-border);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 14px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .crm-topbar-user { display: flex; align-items: center; gap: 10px; flex-shrink: 0; padding: 5px 8px 5px 5px; border-radius: 999px; transition: background 0.15s ease; cursor: pointer; }
        .crm-topbar-user:hover { background: var(--crm-surface); }
        .crm-topbar-user-chevron { color: var(--crm-text-muted); font-size: 11px; }
        .crm-topbar-search {
            flex: 1;
            max-width: 440px;
            margin: 0 auto;
            position: relative;
        }
        .crm-topbar-search input {
            width: 100%; border: 1px solid var(--crm-border); background: var(--crm-surface); border-radius: var(--crm-radius-sm);
            padding: 8px 16px 8px 38px; font-size: 13px;
            outline: none; color: var(--crm-text); transition: all 0.2s ease;
        }
        .crm-topbar-search input:focus { border-color: var(--crm-primary); background: #fff; box-shadow: 0 0 0 3px var(--crm-primary-ring); }
        .crm-topbar-search input::placeholder { color: #A8A29E; }
        .crm-topbar-search .search-icon { position: absolute; {{ App::getLocale() == 'ar' ? 'left' : 'right' }}: 12px; top: 50%; transform: translateY(-50%); color: #A8A29E; font-size: 14px; }
        .crm-topbar-end { display: flex; align-items: center; gap: 6px; margin-{{ App::getLocale() == 'ar' ? 'right' : 'left' }}: auto; flex-shrink: 0; }
        .crm-topbar-btn { background: none; border: none; padding: 7px 9px; border-radius: var(--crm-radius-xs); color: var(--crm-text-secondary); cursor: pointer; position: relative; transition: all 0.15s ease; font-size: 17px; text-decoration: none; display: flex; align-items: center; }
        .crm-topbar-btn:hover { background: var(--crm-primary-light); color: var(--crm-primary); }
        .crm-notif-badge { position: absolute; top: 5px; {{ App::getLocale() == 'ar' ? 'left' : 'right' }}: 5px; width: 8px; height: 8px; background: var(--crm-danger); border-radius: 50%; border: 2px solid var(--crm-bg); }
        .crm-topbar-logo img { max-height: 32px; }
        .crm-user { display: flex; align-items: center; gap: 10px; }
        .crm-user-avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--crm-primary-light); display: flex; align-items: center; justify-content: center; color: var(--crm-primary); font-weight: 700; font-size: 13px; overflow: hidden; transition: box-shadow 0.15s ease; }
        .crm-user-avatar:hover { box-shadow: 0 0 0 3px var(--crm-primary-ring); }
        .crm-user-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .crm-user-name { font-size: 13px; font-weight: 700; color: var(--crm-text); }
        .crm-mob-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            background: none;
            border: none;
            width: 38px;
            height: 38px;
            border-radius: var(--crm-radius-xs);
            color: var(--crm-text);
            font-size: 20px;
            cursor: pointer;
            flex-shrink: 0;
            transition: all 0.15s ease;
        }
        .crm-mob-toggle:hover { background: var(--crm-primary-light); color: var(--crm-primary); }

        .crm-sidebar-close {
            display: none;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 14px;
            {{ App::getLocale() == 'ar' ? 'left' : 'right' }}: 14px;
            background: none;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: var(--crm-radius-xs);
            color: var(--crm-text-muted);
            font-size: 18px;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .crm-sidebar-close:hover { background: var(--crm-surface); color: var(--crm-primary); }

        .crm-mob-overlay { display: none; }

        /* ===== CONTENT ===== */
        .crm-content {
            flex: 1;
            padding: 28px;
        }

        /* ===== CARDS ===== */
        .crm-card {
            background: var(--crm-card-bg);
            border-radius: var(--crm-radius);
            border: 1px solid var(--crm-border);
            box-shadow: var(--crm-shadow-xs);
            padding: 24px;
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }
        .crm-card:hover { box-shadow: var(--crm-shadow); }
        .crm-card-title { font-size: 15px; font-weight: 700; color: var(--crm-text); margin-bottom: 16px; }

        /* ===== STAT CARDS (Unified) ===== */
        .crm-stat-card {
            background: #fff;
            border-radius: var(--crm-radius);
            border: 1px solid var(--crm-border);
            padding: 18px 20px;
            box-shadow: var(--crm-shadow-xs);
            display: flex; flex-direction: column; gap: 6px;
            transition: all 0.2s ease;
        }
        .crm-stat-card:hover { box-shadow: var(--crm-shadow); transform: translateY(-2px); }
        .crm-stat-label { font-size: 12px; color: var(--crm-text-muted); font-weight: 600; }
        .crm-stat-value { font-size: 28px; font-weight: 800; color: var(--crm-text); line-height: 1; letter-spacing: -0.02em; font-variant-numeric: tabular-nums; }
        .crm-stat-sub { font-size: 12px; color: var(--crm-text-muted); font-weight: 600; }
        .crm-stat-card.danger .crm-stat-value { color: var(--crm-danger); }
        .crm-stat-card.info .crm-stat-value { color: var(--crm-blue); }

        /* ===== STAT CARDS (New — icon-based) ===== */
        .crm-stat-new {
            background: #fff;
            border-radius: var(--crm-radius);
            padding: 20px 22px;
            box-shadow: var(--crm-shadow-xs);
            border: 1px solid var(--crm-border);
            position: relative;
            transition: all 0.25s ease;
        }
        .crm-stat-new:hover { box-shadow: var(--crm-shadow-md); transform: translateY(-3px); }
        .crm-stat-new .stat-badge {
            position: absolute; top: 16px;
            {{ App::getLocale() == 'ar' ? 'left' : 'right' }}: 16px;
            font-size: 10.5px; font-weight: 700; padding: 2px 8px; border-radius: 20px;
        }
        .crm-stat-new .stat-badge.orange { background: #FEF3C7; color: #92400E; }
        .crm-stat-new .stat-badge.green  { background: #D1FAE5; color: #065F46; }
        .crm-stat-new .stat-badge.blue   { background: #DBEAFE; color: #1E40AF; }
        .crm-stat-new .stat-icon {
            width: 42px; height: 42px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; margin-bottom: 14px;
        }
        .crm-stat-new .stat-icon.red    { background: #FEF3C7; color: var(--crm-primary); box-shadow: 0 0 0 6px rgba(180, 83, 9, 0.04); }
        .crm-stat-new .stat-icon.green  { background: #D1FAE5; color: var(--crm-success); box-shadow: 0 0 0 6px rgba(5, 150, 105, 0.04); }
        .crm-stat-new .stat-icon.blue   { background: #DBEAFE; color: var(--crm-blue); box-shadow: 0 0 0 6px rgba(2, 132, 199, 0.04); }
        .crm-stat-new .stat-icon.orange { background: #FEF3C7; color: var(--crm-warning); box-shadow: 0 0 0 6px rgba(217, 119, 6, 0.04); }
        .crm-stat-new .stat-icon.purple { background: #EDE9FE; color: var(--crm-purple); box-shadow: 0 0 0 6px rgba(124, 58, 237, 0.04); }
        .crm-stat-new .stat-lbl  { font-size: 12.5px; color: var(--crm-text-muted); font-weight: 600; margin-bottom: 4px; }
        .crm-stat-new .stat-val  { font-size: 26px; font-weight: 800; color: var(--crm-text); line-height: 1; letter-spacing: -0.02em; font-variant-numeric: tabular-nums; }
        .crm-stat-new .stat-sub  { font-size: 11.5px; color: var(--crm-success); font-weight: 700; margin-top: 8px; }

        /* ===== STATUS DOTS ===== */
        .status-dot { display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 20px; white-space: nowrap; }
        .status-dot::before { content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .status-dot.planned   { color: #92400E; background: #FEF3C7; } .status-dot.planned::before   { background: #D97706; }
        .status-dot.waiting   { color: #92400E; background: #FEF3C7; } .status-dot.waiting::before   { background: #D97706; }
        .status-dot.late      { color: #9F1239; background: #FFE4E6; } .status-dot.late::before      { background: var(--crm-danger); }
        .status-dot.done      { color: #065F46; background: #D1FAE5; } .status-dot.done::before      { background: var(--crm-success); }
        .status-dot.confirmed { color: #1E40AF; background: #DBEAFE; } .status-dot.confirmed::before { background: var(--crm-blue); }
        .status-dot.cancelled { color: #57534E; background: #F5F5F4; } .status-dot.cancelled::before { background: #A8A29E; }
        /* Legacy badges */
        .badge-new { background: #DBEAFE; color: #1E40AF; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 800; }
        .badge-active { background: #D1FAE5; color: #065F46; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 800; }
        .badge-pending { background: #FEF3C7; color: #92400E; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 800; }
        .badge-done { background: #EDE9FE; color: #5B21B6; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 800; }
        .badge-rejected { background: #FFE4E6; color: #9F1239; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 800; }

        /* ===== BREADCRUMB ===== */
        .crm-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--crm-text-muted); margin-bottom: 20px; }
        .crm-breadcrumb a { color: var(--crm-text-muted); text-decoration: none; font-weight: 600; transition: color 0.15s ease; }
        .crm-breadcrumb a:hover { color: var(--crm-primary); }
        .crm-breadcrumb .sep { font-size: 10px; opacity: 0.5; }
        .crm-breadcrumb .current { color: var(--crm-text); font-weight: 700; }

        /* ===== FILTER TABS ===== */
        .crm-filter-tabs { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 16px; }
        .crm-filter-tab {
            padding: 7px 16px; border-radius: var(--crm-radius-sm);
            font-size: 13px; font-weight: 600;
            border: 1px solid var(--crm-border); background: #fff;
            color: var(--crm-text-secondary); cursor: pointer;
            transition: all 0.15s ease; text-decoration: none;
        }
        .crm-filter-tab:hover { border-color: var(--crm-primary); color: var(--crm-primary); background: var(--crm-primary-light); }
        .crm-filter-tab.active { background: var(--crm-primary); color: #fff; border-color: var(--crm-primary); }

        /* ===== PAGE HEADER ===== */
        .crm-page-header { margin-bottom: 24px; }
        .crm-page-title { font-size: 22px; font-weight: 800; color: var(--crm-text); margin-bottom: 4px; letter-spacing: -0.02em; line-height: 1.3; }
        .crm-page-sub { font-size: 13.5px; color: var(--crm-text-muted); font-weight: 500; }

        /* ===== TABLES ===== */
        .crm-table { width: 100%; border-collapse: collapse; }
        .crm-table th { font-size: 11px; font-weight: 700; color: var(--crm-text-muted); padding: 12px 16px; text-align: right; border-bottom: 1px solid var(--crm-border); text-transform: uppercase; letter-spacing: 0.05em; }
        .crm-table td { padding: 14px 16px; border-bottom: 1px solid var(--crm-border-light); font-size: 13px; font-weight: 500; color: var(--crm-text); vertical-align: middle; }
        .crm-table tr:hover td { background: var(--crm-surface); }
        .crm-table tr:last-child td { border-bottom: none; }

        /* ===== BUTTONS ===== */
        .btn-crm-primary {
            background: var(--crm-primary-gradient); color: #fff; border: none;
            border-radius: var(--crm-radius-sm); padding: 10px 20px;
            font-weight: 700; font-size: 13px; cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex; align-items: center; gap: 8px;
            text-decoration: none; box-shadow: var(--crm-primary-glow);
        }
        .btn-crm-primary:hover { color: #fff; transform: translateY(-1px); box-shadow: 0 16px 32px -8px rgba(180, 83, 9, 0.4); }
        .btn-crm-primary:active { transform: translateY(0); }

        .btn-crm-light {
            background: var(--crm-surface); color: var(--crm-text-secondary);
            border: 1px solid var(--crm-border); border-radius: var(--crm-radius-sm);
            padding: 10px 20px; font-weight: 600; font-size: 13px;
            cursor: pointer; transition: all 0.15s ease;
            display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
        }
        .btn-crm-light:hover { background: var(--crm-surface-hover); color: var(--crm-text); border-color: #D6D3D1; }

        .btn-crm-outline {
            background: transparent; color: var(--crm-primary);
            border: 1.5px solid var(--crm-primary); border-radius: var(--crm-radius-sm);
            padding: 10px 20px; font-weight: 700; font-size: 13px;
            cursor: pointer; transition: all 0.15s ease;
            display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
        }
        .btn-crm-outline:hover { background: var(--crm-primary); color: #fff; }

        .btn-crm-danger {
            background: var(--crm-danger); color: #fff; border: none;
            border-radius: var(--crm-radius-sm); padding: 10px 20px;
            font-weight: 700; font-size: 13px; cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
        }
        .btn-crm-danger:hover { background: #BE123C; color: #fff; }

        /* ===== SIDEBAR GROUPS ===== */
        button.crm-nav-link,
        button.crm-group-toggle {
            background: none; border: none; outline: none;
            box-shadow: none; -webkit-appearance: none;
            text-align: {{ App::getLocale()=='ar'?'right':'left' }};
            width: 100%;
        }
        button.crm-nav-link:focus,
        button.crm-group-toggle:focus { outline: none; box-shadow: none; }
        button.crm-nav-link.active,
        button.crm-group-toggle.active {
            background: var(--crm-primary-light);
            color: var(--crm-primary);
            border: none;
        }
        .crm-chevron { font-size: 11px !important; margin-{{ App::getLocale()=='ar'?'right':'left' }}: auto; opacity: 0.4; transition: transform 0.2s ease, opacity 0.2s ease; }
        .crm-sub-list { list-style: none; padding: 0; margin: 0; overflow: hidden; max-height: 0; transition: max-height 0.3s ease; }
        .crm-sub-list.open { max-height: 600px; }
        .crm-sub-link {
            display: flex; align-items: center; gap: 8px;
            padding: 7px 12px 7px 34px;
            border-radius: var(--crm-radius-sm);
            color: var(--crm-text-muted); text-decoration: none;
            font-size: 12.5px; font-weight: 500;
            transition: all 0.15s ease;
            margin-bottom: 1px; white-space: nowrap;
        }
        .crm-sub-link i { font-size: 13px; flex-shrink: 0; opacity: 0.7; }
        .crm-sub-link:hover { background: var(--crm-primary-light); color: var(--crm-primary); }
        .crm-sub-link:hover i { opacity: 1; }
        .crm-sub-link.active {
            background: var(--crm-primary-light);
            color: var(--crm-primary);
            font-weight: 700;
            border-{{ App::getLocale()=='ar'?'right':'left' }}: 2px solid var(--crm-primary);
        }
        .crm-sub-link.active i { opacity: 1; }

        /* ===== GLOBAL BOOTSTRAP OVERRIDES ===== */
        .card { border: 1px solid var(--crm-border) !important; border-radius: var(--crm-radius) !important; box-shadow: var(--crm-shadow-xs) !important; }
        .card-header { background: #fff !important; border-bottom: 1px solid var(--crm-border-light) !important; }
        .card-footer { background: #fff !important; border-top: 1px solid var(--crm-border-light) !important; }
        .table thead th { background: var(--crm-surface); font-size: 11px; font-weight: 700; color: var(--crm-text-muted); border-bottom: 1px solid var(--crm-border); padding: 12px 16px; text-transform: uppercase; letter-spacing: 0.05em; }
        .table tbody td { font-size: 13px; font-weight: 500; color: var(--crm-text); border-bottom: 1px solid var(--crm-border-light); padding: 13px 16px; vertical-align: middle; }
        .table-hover tbody tr:hover td { background: var(--crm-surface); }
        .badge { font-size: 11px !important; font-weight: 700 !important; border-radius: 20px !important; padding: 4px 10px !important; }
        .btn-primary { background: var(--crm-primary) !important; border-color: var(--crm-primary) !important; font-weight: 700; border-radius: var(--crm-radius-sm) !important; }
        .btn-primary:hover { background: var(--crm-primary-hover) !important; border-color: var(--crm-primary-hover) !important; }
        .btn-outline-primary { color: var(--crm-primary) !important; border-color: var(--crm-primary) !important; border-radius: var(--crm-radius-sm) !important; font-weight: 700; }
        .btn-outline-primary:hover { background: var(--crm-primary) !important; color: #fff !important; }
        .btn { border-radius: var(--crm-radius-sm) !important; font-family: {{ App::getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Inter', sans-serif" }} !important; transition: all 0.15s ease !important; }
        .form-control, .form-select {
            border: 1px solid var(--crm-border) !important;
            border-radius: var(--crm-radius-sm) !important;
            font-size: 13px; padding: 10px 14px;
            font-family: {{ App::getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Inter', sans-serif" }};
            color: var(--crm-text); background-color: #fff !important;
        }
        .form-control:focus, .form-select:focus { border-color: var(--crm-primary) !important; box-shadow: 0 0 0 3px var(--crm-primary-ring) !important; }
        .form-label { font-size: 12.5px; font-weight: 700; color: var(--crm-text-secondary); margin-bottom: 6px; }
        .form-check-input:checked { background-color: var(--crm-primary); border-color: var(--crm-primary); }
        .alert { border-radius: var(--crm-radius) !important; border: none !important; }
        .crm-page-hdr { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; }
        .crm-page-hdr h5 { font-size: 17px; font-weight: 700; color: var(--crm-text); margin: 0; }
        .input-group-text { background: var(--crm-surface) !important; border: 1px solid var(--crm-border) !important; border-radius: var(--crm-radius-sm) 0 0 var(--crm-radius-sm) !important; color: var(--crm-text-muted) !important; }
        .dropdown-menu { border: 1px solid var(--crm-border) !important; box-shadow: var(--crm-shadow-lg) !important; border-radius: var(--crm-radius) !important; }
        .dropdown-item { font-size: 13px; font-weight: 600; padding: 8px 16px; transition: background 0.12s ease; }
        .dropdown-item:hover { background: var(--crm-surface); color: var(--crm-text); }
        .modal-content { border-radius: var(--crm-radius) !important; border: none !important; box-shadow: var(--crm-shadow-lg) !important; }
        .modal-header { border-bottom: 1px solid var(--crm-border-light) !important; }
        .modal-footer { border-top: 1px solid var(--crm-border-light) !important; }
        .form-check-input { border-radius: 6px; border-color: var(--crm-border); }
        .form-check-input:focus { box-shadow: 0 0 0 3px var(--crm-primary-ring); }
        .form-switch .form-check-input { width: 2.2em; height: 1.2em; border-radius: 999px; }
        .btn-close { filter: none !important; }
        /* Pagination */
        .pagination { display: flex; align-items: center; justify-content: center; gap: 6px; margin: 0; padding: 0; }
        .pagination .page-item { list-style: none; }
        .pagination .page-link {
            display: flex; align-items: center; justify-content: center;
            width: 36px; height: 36px; border-radius: var(--crm-radius-sm);
            border: 1px solid var(--crm-border); background: #fff;
            color: var(--crm-text); font-size: 13px; font-weight: 600;
            transition: all 0.15s ease; text-decoration: none; margin: 0;
        }
        .pagination .page-link:hover:not(.active) { border-color: var(--crm-primary); color: var(--crm-primary); background: var(--crm-primary-light); }
        .pagination .page-item.active .page-link { background: var(--crm-primary) !important; border-color: var(--crm-primary) !important; color: #fff !important; box-shadow: 0 2px 8px rgba(180, 83, 9, 0.25); }
        .pagination .page-item.disabled .page-link { color: #D6D3D1; background: var(--crm-surface); border-color: var(--crm-border); pointer-events: none; }

        /* ===== EMPTY STATE ===== */
        .crm-empty-state { text-align: center; padding: 48px 24px; }
        .crm-empty-state i { font-size: 48px; color: var(--crm-border); display: block; margin-bottom: 16px; }
        .crm-empty-state h6 { font-size: 15px; font-weight: 700; color: var(--crm-text-secondary); margin-bottom: 6px; }
        .crm-empty-state p { font-size: 13px; color: var(--crm-text-muted); margin-bottom: 16px; }

        /* ===== RESPONSIVE — MOBILE DRAWER ===== */
        @media (max-width: 768px) {
            .crm-sidebar {
                transform: translateX({{ App::getLocale() == 'ar' ? '100%' : '-100%' }});
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 1200; box-shadow: none;
            }
            .crm-sidebar.mob-open { transform: translateX(0); box-shadow: var(--crm-shadow-lg); }
            .crm-mob-overlay {
                display: block; position: fixed; inset: 0;
                background: rgba(28, 25, 23, 0.45);
                backdrop-filter: blur(4px);
                z-index: 1100; opacity: 0;
                pointer-events: none; transition: opacity 0.3s ease;
            }
            .crm-mob-overlay.visible { opacity: 1; pointer-events: all; }
            .crm-main { margin-{{ App::getLocale() == 'ar' ? 'right' : 'left' }}: 0 !important; }
            .crm-mob-toggle { display: flex !important; }
            .crm-topbar-search { display: none !important; }
            .crm-topbar { padding: 0 16px; gap: 10px; }
            .crm-content { padding: 16px; }
            .crm-sidebar-close { display: flex !important; }
            .crm-stat-new .stat-val { font-size: 22px; }
            .crm-page-title { font-size: 20px; }
        }
    </style>
</head>
<body class="crm-shell">

    {{-- Mobile Overlay --}}
    <div class="crm-mob-overlay" id="crmMobOverlay"></div>

    @include('partials.crm-sidebar')

    <div class="crm-main">
        @include('partials.crm-topbar')
        <div class="crm-content">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}" onerror="document.write('<script src=\'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js\'><\/script>')"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.min.js"></script>

    @yield('js')
    @yield('scripts')

    <script>
    // ===== CRM Mobile Drawer =====
    (function() {
        const toggle   = document.getElementById('crmMobToggle');
        const sidebar  = document.querySelector('.crm-sidebar');
        const overlay  = document.getElementById('crmMobOverlay');
        const closeBtn = document.getElementById('crmSidebarClose');

        function openDrawer() {
            sidebar.classList.add('mob-open');
            overlay.classList.add('visible');
            document.body.style.overflow = 'hidden';
        }
        function closeDrawer() {
            sidebar.classList.remove('mob-open');
            overlay.classList.remove('visible');
            document.body.style.overflow = '';
        }

        if (toggle)   toggle.addEventListener('click', openDrawer);
        if (overlay)  overlay.addEventListener('click', closeDrawer);
        if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
    })();
    </script>

    {{-- Custom Global Toast Notification --}}
    @if(session('success') || session('error') || (isset($errors) && $errors->any()))
    <div id="crm-toast" class="crm-toast show {{ session('success') ? 'success' : 'error' }}">
        <div class="crm-toast-icon">
            <i class="bi {{ session('success') ? 'bi-check-lg' : 'bi-x-lg' }}"></i>
        </div>
        <div class="crm-toast-content">
            @if(session('success'))
                {{ session('success') }}
            @elseif(session('error'))
                {{ session('error') }}
            @elseif(isset($errors) && $errors->any())
                {{ $errors->first() }}
            @endif
        </div>
        <button class="crm-toast-close" onclick="this.parentElement.remove()">
            <i class="bi bi-x"></i>
        </button>
    </div>
    <style>
        .crm-toast {
            position: fixed;
            bottom: 32px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: #fff;
            padding: 14px 20px;
            border-radius: var(--crm-radius);
            box-shadow: var(--crm-shadow-lg);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            min-width: 300px;
            max-width: 90vw;
            border: 1px solid var(--crm-border);
        }
        .crm-toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
            visibility: visible;
        }
        .crm-toast-icon {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            flex-shrink: 0;
        }
        .crm-toast.success .crm-toast-icon { background: var(--crm-success); box-shadow: 0 4px 12px rgba(5,150,105,0.3); }
        .crm-toast.error .crm-toast-icon { background: var(--crm-danger); box-shadow: 0 4px 12px rgba(225,29,72,0.3); }
        .crm-toast-content { flex: 1; font-size: 13.5px; font-weight: 600; color: var(--crm-text); }
        .crm-toast-close {
            background: none; border: none; color: var(--crm-text-muted);
            cursor: pointer; font-size: 20px; padding: 0;
            display: flex; align-items: center; transition: all 0.15s ease;
        }
        .crm-toast-close:hover { color: var(--crm-text); transform: scale(1.1); }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('crm-toast');
            if(toast) {
                setTimeout(() => {
                    toast.style.transform = 'translateX(-50%) translateY(100px)';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 400);
                }, 4000);
            }
        });
    </script>
    @endif

</body>
</html>
