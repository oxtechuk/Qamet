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
            /* Brand — modern indigo/violet, used flat for UI chrome and as a gradient for hero CTAs */
            --crm-primary: #6366F1;
            --crm-primary-hover: #4F46E5;
            --crm-primary-light: rgba(99, 102, 241, 0.08);
            --crm-primary-ring: rgba(99, 102, 241, 0.16);
            --crm-primary-gradient: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%);
            --crm-primary-glow: 0px 16px 32px -8px rgba(99, 102, 241, 0.35);

            /* Legacy aliases — referenced across other CRM pages, kept in sync with brand tokens */
            --crm-red: var(--crm-primary);
            --crm-red-dark: var(--crm-primary-hover);
            --crm-red-light: var(--crm-primary-light);

            /* Semantic */
            --crm-success: #10B981;
            --crm-warning: #F59E0B;
            --crm-danger: #F43F5E;
            --crm-green: #10B981;
            --crm-orange: #F59E0B;
            --crm-blue: #3B82F6;
            --crm-purple: #8B5CF6;

            /* Layout */
            --crm-sidebar-width: 248px;
            --crm-topbar-height: 68px;

            /* Surfaces & text */
            --crm-bg: #F9FAFB;
            --crm-card-bg: #fff;
            --crm-text: #111827;
            --crm-text-muted: #6B7280;
            --crm-border: #E5E7EB;

            /* Elevation */
            --crm-radius: 16px;
            --crm-radius-sm: 10px;
            --crm-shadow-xs: 0 1px 2px rgba(16, 24, 40, 0.05);
            --crm-shadow: 0 1px 3px rgba(16, 24, 40, 0.05), 0 6px 20px -4px rgba(16, 24, 40, 0.08);
            --crm-shadow-lg: 0 12px 32px -8px rgba(16, 24, 40, 0.16);
        }

        .gr-currency {
            display: inline-block !important;
            width: 20px !important;
            height: 20px !important;
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

        * { box-sizing: border-box; }

        body.crm-shell {
            font-family: {{ App::getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Inter', sans-serif" }};
            background: var(--crm-bg);
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: row;
            opacity: 0;
            animation: fadeInBody 0.3s ease-out forwards;
        }

        @keyframes fadeInBody {
            from { opacity: 0; }
            to { opacity: 1; }
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
            padding: 22px 20px;
            border-bottom: 1px solid var(--crm-border);
            text-align: center;
        }
        .crm-sidebar-logo img { max-height: 40px; }
        .crm-sidebar-brand { color: var(--crm-text); font-weight: 800; font-size: 15px; line-height: 1.2; margin-top: 8px; }
        .crm-sidebar-brand small { color: var(--crm-text-muted); font-size: 10px; font-weight: 600; display: block; letter-spacing: 1px; }

        .crm-nav { flex: 1; padding: 14px 0; background: #fff; }
        .crm-nav-section { padding: 0 12px; margin-bottom: 4px; }
        .crm-nav-label { color: var(--crm-text-muted); font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; padding: 14px 10px 6px; display: block; }

        .crm-nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: var(--crm-radius-sm);
            color: #4B5563;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            transition: background 0.15s ease, color 0.15s ease;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            position: relative;
        }
        .crm-nav-link i { font-size: 16px; width: 18px; text-align: center; flex-shrink: 0; }
        .crm-nav-link:hover { background: var(--crm-primary-light); color: var(--crm-primary); }
        .crm-nav-link.active {
            background: var(--crm-primary-light);
            color: var(--crm-primary);
            font-weight: 700;
        }
        /* Indicator line using pseudo-element to prevent curved border-radius issue */
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
            background: var(--crm-primary); color: #fff;
            border-radius: 10px; font-size: 10px; font-weight: 800; padding: 1px 7px;
        }

        .crm-sidebar-footer {
            padding: 12px 12px 16px;
            border-top: 1px solid var(--crm-border);
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
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(14px) saturate(1.4);
            -webkit-backdrop-filter: blur(14px) saturate(1.4);
            border-bottom: 1px solid var(--crm-border);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .crm-topbar-user { display: flex; align-items: center; gap: 10px; flex-shrink: 0; padding: 6px 8px 6px 6px; border-radius: 999px; transition: background 0.15s ease; }
        .crm-topbar-user:hover { background: var(--crm-bg); }
        .crm-topbar-user-chevron { color: var(--crm-text-muted); font-size: 12px; }
        .crm-topbar-search {
            flex: 1;
            max-width: 480px;
            margin: 0 auto;
            position: relative;
        }
        .crm-topbar-search input {
            width: 100%; border: 1px solid var(--crm-border); background: var(--crm-bg); border-radius: 10px;
            padding: 9px 18px 9px 40px; font-size: 13.5px; font-family: 'Cairo', sans-serif;
            outline: none; color: var(--crm-text); transition: border-color 0.15s ease, background 0.15s ease, box-shadow 0.15s ease;
        }
        .crm-topbar-search input:focus { border-color: var(--crm-primary); background: #fff; box-shadow: 0 0 0 3px var(--crm-primary-ring); }
        .crm-topbar-search input::placeholder { color: #9CA3AF; }
        .crm-topbar-search .search-icon { position: absolute; {{ App::getLocale() == 'ar' ? 'left' : 'right' }}: 14px; top: 50%; transform: translateY(-50%); color: #9CA3AF; font-size: 15px; }
        .crm-topbar-end { display: flex; align-items: center; gap: 8px; margin-{{ App::getLocale() == 'ar' ? 'right' : 'left' }}: auto; flex-shrink: 0; }
        .crm-topbar-btn { background: none; border: none; padding: 8px 10px; border-radius: var(--crm-radius-sm); color: #4B5563; cursor: pointer; position: relative; transition: background 0.15s ease, color 0.15s ease; font-size: 18px; text-decoration: none; display: flex; align-items: center; }
        .crm-topbar-btn:hover { background: var(--crm-bg); color: var(--crm-primary); }
        .crm-notif-badge { position: absolute; top: 6px; {{ App::getLocale() == 'ar' ? 'left' : 'right' }}: 6px; width: 8px; height: 8px; background: var(--crm-danger); border-radius: 50%; border: 2px solid #fff; }
        .crm-topbar-logo img { max-height: 34px; }
        .crm-user { display: flex; align-items: center; gap: 10px; }
        .crm-user-avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--crm-primary-light); display: flex; align-items: center; justify-content: center; color: var(--crm-primary); font-weight: 700; font-size: 13px; overflow: hidden; }
        .crm-user-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .crm-user-name { font-size: 13px; font-weight: 700; color: var(--crm-text); }
        /* Hamburger - hidden on desktop */
        .crm-mob-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            background: none;
            border: none;
            width: 38px;
            height: 38px;
            border-radius: var(--crm-radius-sm);
            color: var(--crm-text);
            font-size: 20px;
            cursor: pointer;
            flex-shrink: 0;
            transition: background 0.15s ease, color 0.15s ease;
        }
        .crm-mob-toggle:hover { background: var(--crm-primary-light); color: var(--crm-primary); }

        /* Close button inside sidebar - hidden on desktop */
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
            border-radius: 8px;
            color: var(--crm-text-muted);
            font-size: 18px;
            cursor: pointer;
        }
        .crm-sidebar-close:hover { background: var(--crm-bg); color: var(--crm-primary); }

        /* Mobile Overlay - hidden on desktop */
        .crm-mob-overlay { display: none; }

        /* ===== CONTENT ===== */
        .crm-content {
            flex: 1;
            padding: 32px;
        }

        /* ===== CARDS ===== */
        .crm-card {
            background: var(--crm-card-bg);
            border-radius: var(--crm-radius);
            border: 1px solid var(--crm-border);
            box-shadow: var(--crm-shadow-xs);
            padding: 24px;
        }
        .crm-card-title { font-size: 15px; font-weight: 700; color: var(--crm-text); margin-bottom: 16px; }

        /* ===== STAT CARDS ===== */
        .crm-stat-card {
            background: #fff;
            border-radius: var(--crm-radius);
            border: 1px solid var(--crm-border);
            padding: 20px 24px;
            box-shadow: var(--crm-shadow-xs);
            display: flex; flex-direction: column; gap: 8px;
        }
        .crm-stat-label { font-size: 12px; color: var(--crm-text-muted); font-weight: 700; text-align: left; }
        .crm-stat-value { font-size: 32px; font-weight: 800; color: var(--crm-text); line-height: 1; letter-spacing: -0.02em; }
        .crm-stat-sub { font-size: 12px; color: var(--crm-text-muted); font-weight: 700; }
        .crm-stat-card.danger .crm-stat-value { color: var(--crm-danger); }
        .crm-stat-card.info .crm-stat-value { color: var(--crm-blue); }

        /* ===== STATUS DOTS (New Design) ===== */
        .status-dot { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px; }
        .status-dot::before { content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .status-dot.planned   { color: #B45309; background: #FFFBEB; } .status-dot.planned::before   { background: var(--crm-warning); }
        .status-dot.waiting   { color: #B45309; background: #FFFBEB; } .status-dot.waiting::before   { background: var(--crm-warning); }
        .status-dot.late      { color: #BE123C; background: #FFF1F2; } .status-dot.late::before      { background: var(--crm-danger); }
        .status-dot.done      { color: #047857; background: #ECFDF5; } .status-dot.done::before      { background: var(--crm-success); }
        .status-dot.confirmed { color: #1D4ED8; background: #EFF6FF; } .status-dot.confirmed::before { background: var(--crm-blue); }
        .status-dot.cancelled { color: #4B5563; background: #F3F4F6; } .status-dot.cancelled::before { background: #9CA3AF; }
        /* Legacy badges kept for compatibility */
        .badge-new { background: #E3F2FD; color: #1565C0; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 800; }
        .badge-active { background: #E8F5E9; color: #2E7D32; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 800; }
        .badge-pending { background: #FFF3E0; color: #E65100; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 800; }
        .badge-done { background: #F3E5F5; color: #6A1B9A; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 800; }
        .badge-rejected { background: #FFEBEE; color: #B71C1C; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 800; }

        /* ===== BREADCRUMB ===== */
        .crm-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--crm-text-muted); margin-bottom: 20px; }
        .crm-breadcrumb a { color: var(--crm-text-muted); text-decoration: none; font-weight: 600; }
        .crm-breadcrumb a:hover { color: var(--crm-primary); }
        .crm-breadcrumb .sep { font-size: 11px; opacity: 0.6; }
        .crm-breadcrumb .current { color: var(--crm-text); font-weight: 700; }

        /* ===== FILTER TABS ===== */
        .crm-filter-tabs { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 16px; }
        .crm-filter-tab { padding: 7px 16px; border-radius: var(--crm-radius-sm); font-size: 13px; font-weight: 700; border: 1px solid var(--crm-border); background: #fff; color: #4B5563; cursor: pointer; transition: 0.15s; text-decoration: none; }
        .crm-filter-tab:hover { border-color: var(--crm-primary); color: var(--crm-primary); }
        .crm-filter-tab.active { background: var(--crm-primary); color: #fff; border-color: var(--crm-primary); }

        /* ===== NEW STAT CARD ===== */
        .crm-stat-new { background: #fff; border-radius: var(--crm-radius); padding: 20px 22px; box-shadow: var(--crm-shadow-xs); border: 1px solid var(--crm-border); position: relative; }
        .crm-stat-new .stat-badge { position: absolute; top: 16px; {{ App::getLocale() == 'ar' ? 'left' : 'right' }}: 16px; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 20px; }
        .crm-stat-new .stat-badge.orange { background: #FFFBEB; color: #B45309; }
        .crm-stat-new .stat-badge.green  { background: #ECFDF5; color: #047857; }
        .crm-stat-new .stat-badge.blue   { background: #EFF6FF; color: #1D4ED8; }
        .crm-stat-new .stat-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 19px; margin-bottom: 14px; }
        .crm-stat-new .stat-icon.red    { background: var(--crm-primary-light); color: var(--crm-primary); box-shadow: 0 0 0 8px rgba(99, 102, 241, 0.04); }
        .crm-stat-new .stat-icon.green  { background: #ECFDF5; color: var(--crm-success); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0.04); }
        .crm-stat-new .stat-icon.blue   { background: #EFF6FF; color: var(--crm-blue); box-shadow: 0 0 0 8px rgba(59, 130, 246, 0.04); }
        .crm-stat-new .stat-icon.orange { background: #FFFBEB; color: var(--crm-warning); box-shadow: 0 0 0 8px rgba(245, 158, 11, 0.04); }
        .crm-stat-new .stat-icon.purple { background: #F5F3FF; color: var(--crm-purple); box-shadow: 0 0 0 8px rgba(139, 92, 246, 0.04); }
        .crm-stat-new { transition: box-shadow 0.2s ease, transform 0.2s ease; }
        .crm-stat-new:hover { box-shadow: var(--crm-shadow); transform: translateY(-2px); }
        .crm-stat-new .stat-lbl  { font-size: 12.5px; color: var(--crm-text-muted); font-weight: 600; margin-bottom: 6px; }
        .crm-stat-new .stat-val  { font-size: 26px; font-weight: 800; color: var(--crm-text); line-height: 1; letter-spacing: -0.02em; }
        .crm-stat-new .stat-sub  { font-size: 11.5px; color: var(--crm-success); font-weight: 700; margin-top: 8px; }

        /* ===== PAGE HEADER ===== */
        .crm-page-header { margin-bottom: 28px; }
        .crm-page-title { font-size: 24px; font-weight: 800; color: var(--crm-text); margin-bottom: 4px; letter-spacing: -0.02em; }
        .crm-page-sub { font-size: 13.5px; color: var(--crm-text-muted); font-weight: 500; }

        /* ===== TABLES ===== */
        .crm-table { width: 100%; border-collapse: collapse; }
        .crm-table th { font-size: 11.5px; font-weight: 700; color: var(--crm-text-muted); padding: 12px 16px; text-align: right; border-bottom: 1px solid var(--crm-border); text-transform: uppercase; letter-spacing: 0.04em; }
        .crm-table td { padding: 14px 16px; border-bottom: 1px solid #F3F4F6; font-size: 13px; font-weight: 500; color: var(--crm-text); vertical-align: middle; }
        .crm-table tr:hover td { background: var(--crm-bg); }
        .crm-table tr:last-child td { border-bottom: none; }

        /* ===== BUTTONS ===== */
        .btn-crm-primary { background: var(--crm-primary-gradient); color: #fff; border: none; border-radius: var(--crm-radius-sm); padding: 10px 18px; font-weight: 700; font-size: 13px; font-family: 'Cairo', sans-serif; cursor: pointer; transition: opacity 0.15s ease, transform 0.15s ease, box-shadow 0.15s ease; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; box-shadow: var(--crm-primary-glow); }
        .btn-crm-primary:hover { opacity: 0.92; color: #fff; transform: translateY(-1px); }
        .btn-crm-light { background: var(--crm-bg); color: #374151; border: 1px solid var(--crm-border); border-radius: var(--crm-radius-sm); padding: 10px 18px; font-weight: 700; font-size: 13px; font-family: 'Cairo', sans-serif; cursor: pointer; transition: background 0.15s ease, color 0.15s ease; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; }
        .btn-crm-light:hover { background: #EEF0F3; color: var(--crm-text); }
        .btn-crm-outline {width: 50%; background: transparent; color: var(--crm-primary); border: 1.5px solid var(--crm-primary); border-radius: var(--crm-radius-sm);  font-weight: 700; font-size: 13px; font-family: 'Cairo', sans-serif; cursor: pointer; transition: 0.15s; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; }
        .btn-crm-outline:hover { background: var(--crm-primary); color: #fff; }

        /* ===== SIDEBAR GROUPS ===== */
        /* Reset button default styles for group toggles */
        button.crm-nav-link,
        button.crm-group-toggle {
            background: none;
            border: none;
            outline: none;
            box-shadow: none;
            -webkit-appearance: none;
            text-align: {{ App::getLocale()=='ar'?'right':'left' }};
            width: 100%;
        }
        button.crm-nav-link:focus,
        button.crm-group-toggle:focus { outline: none; box-shadow: none; }
        /* Active group toggle — no side border, just subtle background */
        button.crm-nav-link.active,
        button.crm-group-toggle.active {
            background: var(--crm-primary-light);
            color: var(--crm-primary);
            border: none;
        }
        .crm-chevron { font-size: 11px !important; margin-{{ App::getLocale()=='ar'?'right':'left' }}: auto; opacity: 0.45; transition: transform 0.2s ease, opacity 0.2s ease; }
        .crm-sub-list { list-style: none; padding: 0; margin: 0; overflow: hidden; max-height: 0; transition: max-height 0.25s ease; }
        .crm-sub-list.open { max-height: 500px; }
        .crm-sub-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px 7px 34px;
            border-radius: var(--crm-radius-sm);
            color: #6B7280;
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 500;
            transition: background 0.15s ease, color 0.15s ease;
            margin-bottom: 1px;
            white-space: nowrap;
        }
        .crm-sub-link i { font-size: 13px; flex-shrink: 0; opacity: 0.8; }
        .crm-sub-link:hover { background: var(--crm-primary-light); color: var(--crm-primary); }
        .crm-sub-link.active {
            background: var(--crm-primary-light);
            color: var(--crm-primary);
            font-weight: 700;
            border-{{ App::getLocale()=='ar'?'right':'left' }}: 2px solid var(--crm-primary);
        }

        /* ===== GLOBAL PAGE OVERRIDES (all pages use new style) ===== */
        /* Cards */
        .card { border: 1px solid var(--crm-border) !important; border-radius: var(--crm-radius) !important; box-shadow: var(--crm-shadow-xs) !important; }
        .card-header { background: #fff !important; border-bottom: 1px solid var(--crm-border) !important; }
        .card-footer { background: #fff !important; border-top: 1px solid var(--crm-border) !important; }
        /* Tables */
        .table thead th { background: var(--crm-bg); font-size: 11.5px; font-weight: 700; color: var(--crm-text-muted); border-bottom: 1px solid var(--crm-border); padding: 12px 16px; text-transform: uppercase; letter-spacing: 0.04em; }
        .table tbody td { font-size: 13px; font-weight: 500; color: var(--crm-text); border-bottom: 1px solid #F3F4F6; padding: 13px 16px; vertical-align: middle; }
        .table-hover tbody tr:hover td { background: var(--crm-bg); }
        /* Badges override */
        .badge { font-size: 11px !important; font-weight: 700 !important; border-radius: 20px !important; padding: 4px 10px !important; }
        /* Buttons */
        .btn-primary { background: var(--crm-primary) !important; border-color: var(--crm-primary) !important; font-weight: 700; border-radius: var(--crm-radius-sm) !important; }
        .btn-primary:hover { background: var(--crm-primary-hover) !important; border-color: var(--crm-primary-hover) !important; }
        .btn-outline-primary { color: var(--crm-primary) !important; border-color: var(--crm-primary) !important; border-radius: var(--crm-radius-sm) !important; font-weight: 700; }
        .btn-outline-primary:hover { background: var(--crm-primary) !important; color: #fff !important; }
        .btn { border-radius: var(--crm-radius-sm) !important; font-family: {{ App::getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Inter', sans-serif" }} !important; transition: background 0.15s ease, color 0.15s ease, transform 0.15s ease !important; }
        /* Forms */
        .form-control, .form-select {
            border: 1px solid var(--crm-border) !important;
            border-radius: var(--crm-radius-sm) !important;
            font-size: 13px;
            padding: 10px 14px;
            font-family: {{ App::getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Inter', sans-serif" }};
            color: var(--crm-text);
        }
        .form-control:focus, .form-select:focus { border-color: var(--crm-primary) !important; box-shadow: 0 0 0 3px var(--crm-primary-ring) !important; }
        .form-label { font-size: 13px; font-weight: 700; color: var(--crm-text); margin-bottom: 6px; }
        /* Alert */
        .alert { border-radius: var(--crm-radius) !important; border: none !important; }
        /* Page Header Helpers */
        .crm-page-hdr { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; }
        .crm-page-hdr h5 { font-size: 17px; font-weight: 700; color: var(--crm-text); margin: 0; }
        /* input-group */
        .input-group-text { background: var(--crm-bg) !important; border: 1px solid var(--crm-border) !important; border-radius: var(--crm-radius-sm) 0 0 var(--crm-radius-sm) !important; }
        /* Pagination */
        .pagination { display: flex; align-items: center; justify-content: center; gap: 6px; margin: 0; padding: 0; }
        .pagination .page-item { list-style: none; }
        .pagination .page-link {
            display: flex; align-items: center; justify-content: center;
            width: 36px; height: 36px; border-radius: 10px;
            border: 1px solid var(--crm-border); background: #fff;
            color: var(--crm-text); font-size: 13px; font-weight: 600;
            transition: all 0.15s ease; text-decoration: none; margin: 0;
        }
        .pagination .page-link:hover:not(.active) {
            border-color: var(--crm-primary); color: var(--crm-primary);
            background: var(--crm-primary-light);
        }
        .pagination .page-item.active .page-link {
            background: var(--crm-primary) !important; border-color: var(--crm-primary) !important;
            color: #fff !important; box-shadow: 0 2px 8px rgba(99, 102, 241, 0.25);
        }
        .pagination .page-item.disabled .page-link {
            color: #D1D5DB; background: #F9FAFB; border-color: var(--crm-border); pointer-events: none;
        }
        /* ===== RESPONSIVE — MOBILE DRAWER ===== */
        @media (max-width: 768px) {

            /* Hide desktop sidebar completely */
            .crm-sidebar {
                transform: translateX({{ App::getLocale() == 'ar' ? '100%' : '-100%' }});
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 1200;
                box-shadow: none;
            }
            .crm-sidebar.mob-open {
                transform: translateX(0);
                box-shadow: var(--crm-shadow-lg);
            }

            /* Overlay */
            .crm-mob-overlay {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(17, 24, 39, 0.5);
                z-index: 1100;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
            }
            .crm-mob-overlay.visible {
                opacity: 1;
                pointer-events: all;
            }

            /* Main takes full width */
            .crm-main {
                margin-{{ App::getLocale() == 'ar' ? 'right' : 'left' }}: 0 !important;
            }

            /* Topbar: show hamburger, hide search */
            .crm-mob-toggle { display: flex !important; }
            .crm-topbar-search { display: none !important; }
            .crm-topbar { padding: 0 16px; gap: 10px; }

            /* Content padding */
            .crm-content { padding: 16px; }

            /* Sidebar close btn */
            .crm-sidebar-close { display: flex !important; }
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
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: #fff;
            padding: 14px 20px;
            border-radius: var(--crm-radius);
            box-shadow: var(--crm-shadow-lg);
            display: flex;
            align-items: center;
            gap: 14px;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            min-width: 320px;
            max-width: 90vw;
            border: 1px solid var(--crm-border);
        }
        .crm-toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
            visibility: visible;
        }
        .crm-toast-icon {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            flex-shrink: 0;
        }
        .crm-toast.success .crm-toast-icon { background: var(--crm-success); box-shadow: 0 4px 12px rgba(16,185,129,0.3); }
        .crm-toast.error .crm-toast-icon { background: var(--crm-danger); box-shadow: 0 4px 12px rgba(244,63,94,0.3); }
        .crm-toast-content {
            flex: 1;
            font-size: 14px;
            font-weight: 700;
            color: var(--crm-text);
        }
        .crm-toast-close {
            background: none;
            border: none;
            color: var(--crm-text-muted);
            cursor: pointer;
            font-size: 22px;
            padding: 0;
            display: flex;
            align-items: center;
            transition: 0.2s;
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
