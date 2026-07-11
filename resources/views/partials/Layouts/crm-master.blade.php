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
            --crm-red: #E30613;
            --crm-red-dark: #B1000D;
            --crm-red-light: rgba(227, 6, 19, 0.08);
            --crm-sidebar-width: 220px;
            --crm-topbar-height: 64px;
            --crm-bg: #F5F6FA;
            --crm-card-bg: #fff;
            --crm-text: #1C1C28;
            --crm-text-muted: #8E92A4;
            --crm-shadow: 0 2px 12px rgba(0,0,0,0.06);
            --crm-radius: 14px;
            --crm-border: #ECEEF2;
            --crm-green: #12B76A;
            --crm-orange: #F79009;
            --crm-blue: #2E90FA;
            --crm-purple: #7C3AED;
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
            color: #C0152A !important;
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
            animation: fadeInBody 0.4s ease-out forwards;
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
            box-shadow: {{ App::getLocale() == 'ar' ? '-2px' : '2px' }} 0 12px rgba(0,0,0,0.04);
        }
        .crm-sidebar::-webkit-scrollbar { display: none; }

        .crm-sidebar-logo {
            background: #fff;
            padding: 18px 16px;
            border-bottom: 1px solid var(--crm-border);
            text-align: center;
        }
        .crm-sidebar-logo img { max-height: 44px; }
        .crm-sidebar-brand { color: var(--crm-text); font-weight: 900; font-size: 15px; line-height: 1.2; margin-top: 8px; }
        .crm-sidebar-brand small { color: var(--crm-text-muted); font-size: 10px; font-weight: 600; display: block; letter-spacing: 1px; }

        .crm-nav { flex: 1; padding: 12px 0; background: #fff; }
        .crm-nav-section { padding: 0 10px; margin-bottom: 2px; }
        .crm-nav-label { color: var(--crm-text-muted); font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; padding: 10px 8px 4px; display: block; }

        .crm-nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 10px;
            color: #5A607F;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            transition: 0.18s;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            position: relative;
        }
        .crm-nav-link i { font-size: 17px; flex-shrink: 0; }
        .crm-nav-link:hover { background: var(--crm-red-light); color: var(--crm-red); }
        .crm-nav-link.active {
            background: var(--crm-red-light);
            color: var(--crm-red);
        }
        /* Border indicator only on direct <a> links, not group toggles */
        a.crm-nav-link.active {
            border-{{ App::getLocale() == 'ar' ? 'right' : 'left' }}: 3px solid var(--crm-red);
        }
        .crm-nav-link .nav-badge {
            margin-{{ App::getLocale() == 'ar' ? 'right' : 'left' }}: auto;
            background: var(--crm-red); color: #fff;
            border-radius: 10px; font-size: 10px; font-weight: 900; padding: 1px 7px;
        }

        .crm-sidebar-footer {
            padding: 12px 10px;
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
            background: #fff;
            border-bottom: 1px solid var(--crm-border);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .crm-topbar-user { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
        .crm-topbar-user-chevron { color: var(--crm-text-muted); font-size: 12px; }
        .crm-topbar-search {
            flex: 1;
            max-width: 500px;
            margin: 0 auto;
            position: relative;
        }
        .crm-topbar-search input {
            width: 100%; border: 1px solid var(--crm-border); background: #F8F9FC; border-radius: 30px;
            padding: 9px 18px 9px 40px; font-size: 13px; font-family: 'Cairo', sans-serif;
            outline: none; color: #333; transition: 0.2s;
        }
        .crm-topbar-search input:focus { border-color: var(--crm-red); background: #fff; }
        .crm-topbar-search input::placeholder { color: #bbb; }
        .crm-topbar-search .search-icon { position: absolute; {{ App::getLocale() == 'ar' ? 'left' : 'right' }}: 14px; top: 50%; transform: translateY(-50%); color: #bbb; font-size: 15px; }
        .crm-topbar-end { display: flex; align-items: center; gap: 12px; margin-{{ App::getLocale() == 'ar' ? 'right' : 'left' }}: auto; flex-shrink: 0; }
        .crm-topbar-btn { background: none; border: none; padding: 8px 10px; border-radius: 10px; color: #555; cursor: pointer; position: relative; transition: 0.2s; font-size: 18px; text-decoration: none; display: flex; align-items: center; }
        .crm-topbar-btn:hover { background: #f5f5f5; color: var(--crm-red); }
        .crm-notif-badge { position: absolute; top: 6px; {{ App::getLocale() == 'ar' ? 'left' : 'right' }}: 6px; width: 8px; height: 8px; background: var(--crm-red); border-radius: 50%; border: 2px solid #fff; }
        .crm-topbar-logo img { max-height: 38px; }
        .crm-user { display: flex; align-items: center; gap: 10px; }
        .crm-user-avatar { width: 36px; height: 36px; border-radius: 50%; background: var(--crm-red-light); display: flex; align-items: center; justify-content: center; color: var(--crm-red); font-weight: 800; font-size: 14px; overflow: hidden; }
        .crm-user-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .crm-user-name { font-size: 13px; font-weight: 800; color: #333; }
        /* Hamburger - hidden on desktop */
        .crm-mob-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            background: none;
            border: none;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            color: var(--crm-text);
            font-size: 20px;
            cursor: pointer;
            flex-shrink: 0;
            transition: 0.2s;
        }
        .crm-mob-toggle:hover { background: var(--crm-red-light); color: var(--crm-red); }

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
        .crm-sidebar-close:hover { background: #f5f5f5; color: var(--crm-red); }

        /* Mobile Overlay - hidden on desktop */
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
            border: none;
            box-shadow: var(--crm-shadow);
            padding: 24px;
        }
        .crm-card-title { font-size: 16px; font-weight: 800; color: var(--crm-text); margin-bottom: 16px; }

        /* ===== STAT CARDS ===== */
        .crm-stat-card {
            background: #fff;
            border-radius: var(--crm-radius);
            padding: 20px 24px;
            box-shadow: var(--crm-shadow);
            display: flex; flex-direction: column; gap: 8px;
        }
        .crm-stat-label { font-size: 12px; color: var(--crm-text-muted); font-weight: 700; text-align: left; }
        .crm-stat-value { font-size: 36px; font-weight: 900; color: var(--crm-text); line-height: 1; }
        .crm-stat-sub { font-size: 12px; color: var(--crm-text-muted); font-weight: 700; }
        .crm-stat-card.danger .crm-stat-value { color: var(--crm-red); }
        .crm-stat-card.info .crm-stat-value { color: #1877F2; }

        /* ===== STATUS DOTS (New Design) ===== */
        .status-dot { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px; }
        .status-dot::before { content: ''; width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
        .status-dot.planned   { color: #F79009; background: #FFF8EC; } .status-dot.planned::before   { background: #F79009; }
        .status-dot.waiting   { color: #E8A800; background: #FFFBEA; } .status-dot.waiting::before   { background: #E8A800; }
        .status-dot.late      { color: var(--crm-red); background: #FFF0F0; } .status-dot.late::before      { background: var(--crm-red); }
        .status-dot.done      { color: #12B76A; background: #EDFAF4; } .status-dot.done::before      { background: #12B76A; }
        .status-dot.confirmed { color: #2E90FA; background: #EFF8FF; } .status-dot.confirmed::before { background: #2E90FA; }
        .status-dot.cancelled { color: #8E92A4; background: #F5F6FA; } .status-dot.cancelled::before { background: #8E92A4; }
        /* Legacy badges kept for compatibility */
        .badge-new { background: #E3F2FD; color: #1565C0; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 800; }
        .badge-active { background: #E8F5E9; color: #2E7D32; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 800; }
        .badge-pending { background: #FFF3E0; color: #E65100; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 800; }
        .badge-done { background: #F3E5F5; color: #6A1B9A; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 800; }
        .badge-rejected { background: #FFEBEE; color: #B71C1C; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 800; }

        /* ===== BREADCRUMB ===== */
        .crm-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--crm-text-muted); margin-bottom: 20px; }
        .crm-breadcrumb a { color: var(--crm-text-muted); text-decoration: none; font-weight: 600; }
        .crm-breadcrumb a:hover { color: var(--crm-red); }
        .crm-breadcrumb .sep { font-size: 11px; }
        .crm-breadcrumb .current { color: var(--crm-red); font-weight: 700; }

        /* ===== FILTER TABS ===== */
        .crm-filter-tabs { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 16px; }
        .crm-filter-tab { padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; border: 1.5px solid var(--crm-border); background: #fff; color: #5A607F; cursor: pointer; transition: 0.15s; text-decoration: none; }
        .crm-filter-tab:hover { border-color: var(--crm-red); color: var(--crm-red); }
        .crm-filter-tab.active { background: var(--crm-red); color: #fff; border-color: var(--crm-red); }

        /* ===== NEW STAT CARD ===== */
        .crm-stat-new { background: #fff; border-radius: var(--crm-radius); padding: 18px 20px; box-shadow: var(--crm-shadow); border: 1px solid var(--crm-border); position: relative; }
        .crm-stat-new .stat-badge { position: absolute; top: 14px; {{ App::getLocale() == 'ar' ? 'left' : 'right' }}: 14px; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 20px; }
        .crm-stat-new .stat-badge.orange { background: #FFF3E0; color: #E65100; }
        .crm-stat-new .stat-badge.green  { background: #E8F5E9; color: #2E7D32; }
        .crm-stat-new .stat-badge.blue   { background: #E3F2FD; color: #1565C0; }
        .crm-stat-new .stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 12px; }
        .crm-stat-new .stat-icon.red    { background: #FFF0F0; color: var(--crm-red); }
        .crm-stat-new .stat-icon.green  { background: #EDFAF4; color: #12B76A; }
        .crm-stat-new .stat-icon.blue   { background: #EFF8FF; color: #2E90FA; }
        .crm-stat-new .stat-icon.orange { background: #FFF8EC; color: #F79009; }
        .crm-stat-new .stat-icon.purple { background: #F5F0FF; color: #7C3AED; }
        .crm-stat-new .stat-lbl  { font-size: 12px; color: var(--crm-text-muted); font-weight: 600; margin-bottom: 4px; }
        .crm-stat-new .stat-val  { font-size: 28px; font-weight: 900; color: var(--crm-text); line-height: 1; }
        .crm-stat-new .stat-sub  { font-size: 11px; color: var(--crm-green); font-weight: 700; margin-top: 6px; }

        /* ===== PAGE HEADER ===== */
        .crm-page-header { margin-bottom: 24px; }
        .crm-page-title { font-size: 28px; font-weight: 900; color: var(--crm-text); margin-bottom: 4px; }
        .crm-page-sub { font-size: 14px; color: var(--crm-text-muted); font-weight: 600; }

        /* ===== TABLES ===== */
        .crm-table { width: 100%; border-collapse: collapse; }
        .crm-table th { font-size: 12px; font-weight: 800; color: var(--crm-text-muted); padding: 12px 16px; text-align: right; border-bottom: 1px solid #f0f0f0; }
        .crm-table td { padding: 14px 16px; border-bottom: 1px solid #f7f7f7; font-size: 13px; font-weight: 600; color: #333; vertical-align: middle; }
        .crm-table tr:hover td { background: #FAFAFA; }
        .crm-table tr:last-child td { border-bottom: none; }

        /* ===== BUTTONS ===== */
        .btn-crm-primary { background: var(--crm-red); color: #fff; border: none; border-radius: 12px; padding: 10px 20px; font-weight: 800; font-size: 13px; font-family: 'Cairo', sans-serif; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; }
        .btn-crm-primary:hover { background: var(--crm-red-dark); color: #fff; transform: translateY(-1px); }
        .btn-crm-light { background: #f5f5f7; color: #555; border: none; border-radius: 12px; padding: 10px 20px; font-weight: 800; font-size: 13px; font-family: 'Cairo', sans-serif; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; }
        .btn-crm-light:hover { background: #ececec; color: #333; }
        .btn-crm-outline {width: 50%; background: transparent; color: var(--crm-red); border: 2px solid var(--crm-red); border-radius: 12px;  font-weight: 800; font-size: 13px; font-family: 'Cairo', sans-serif; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; }
        .btn-crm-outline:hover { background: var(--crm-red); color: #fff; }

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
            background: var(--crm-red-light);
            color: var(--crm-red);
            border: none;
        }
        .crm-chevron { font-size: 11px !important; margin-{{ App::getLocale()=='ar'?'right':'left' }}: auto; opacity: 0.5; transition: 0.2s; }
        .crm-sub-list { list-style: none; padding: 0; margin: 0; overflow: hidden; max-height: 0; transition: max-height 0.28s ease; }
        .crm-sub-list.open { max-height: 500px; }
        .crm-sub-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 14px 7px 30px;
            border-radius: 8px;
            color: #7A8099;
            text-decoration: none;
            font-size: 12.5px;
            font-weight: 600;
            transition: 0.15s;
            margin-bottom: 1px;
            white-space: nowrap;
        }
        .crm-sub-link i { font-size: 13px; flex-shrink: 0; opacity: 0.8; }
        .crm-sub-link:hover { background: var(--crm-red-light); color: var(--crm-red); }
        .crm-sub-link.active {
            background: var(--crm-red-light);
            color: var(--crm-red);
            font-weight: 700;
            border-{{ App::getLocale()=='ar'?'right':'left' }}: 3px solid var(--crm-red);
        }

        /* ===== GLOBAL PAGE OVERRIDES (all pages use new style) ===== */
        /* Cards */
        .card { border: 1px solid var(--crm-border) !important; border-radius: var(--crm-radius) !important; box-shadow: var(--crm-shadow) !important; }
        .card-header { background: #fff !important; border-bottom: 1px solid var(--crm-border) !important; }
        .card-footer { background: #fff !important; border-top: 1px solid var(--crm-border) !important; }
        /* Tables */
        .table thead th { background: #F8F9FC; font-size: 12px; font-weight: 700; color: var(--crm-text-muted); border-bottom: 1px solid var(--crm-border); padding: 12px 16px; }
        .table tbody td { font-size: 13px; font-weight: 600; color: var(--crm-text); border-bottom: 1px solid #F5F6FA; padding: 13px 16px; vertical-align: middle; }
        .table-hover tbody tr:hover td { background: #FAFBFD; }
        /* Badges override */
        .badge { font-size: 11px !important; font-weight: 700 !important; border-radius: 20px !important; padding: 4px 10px !important; }
        /* Buttons */
        .btn-primary { background: var(--crm-red) !important; border-color: var(--crm-red) !important; font-weight: 700; border-radius: 10px !important; }
        .btn-primary:hover { background: var(--crm-red-dark) !important; border-color: var(--crm-red-dark) !important; }
        .btn-outline-primary { color: var(--crm-red) !important; border-color: var(--crm-red) !important; border-radius: 10px !important; font-weight: 700; }
        .btn-outline-primary:hover { background: var(--crm-red) !important; color: #fff !important; }
        .btn { border-radius: 10px !important; font-family: {{ App::getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Inter', sans-serif" }} !important; }
        /* Forms */
        .form-control, .form-select {
            border: 1px solid var(--crm-border) !important;
            border-radius: 10px !important;
            font-size: 13px;
            padding: 10px 14px;
            font-family: {{ App::getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Inter', sans-serif" }};
        }
        .form-control:focus, .form-select:focus { border-color: var(--crm-red) !important; box-shadow: 0 0 0 3px rgba(227,6,19,0.08) !important; }
        .form-label { font-size: 13px; font-weight: 700; color: var(--crm-text); margin-bottom: 6px; }
        /* Alert */
        .alert { border-radius: var(--crm-radius) !important; border: none !important; }
        /* Page Header Helpers */
        .crm-page-hdr { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; }
        .crm-page-hdr h5 { font-size: 18px; font-weight: 800; color: var(--crm-text); margin: 0; }
        /* input-group */
        .input-group-text { background: #F8F9FC !important; border: 1px solid var(--crm-border) !important; border-radius: 10px 0 0 10px !important; }
        /* Pagination */
        .pagination .page-link { border-radius: 8px !important; border: 1px solid var(--crm-border); color: var(--crm-text); font-size: 13px; font-weight: 700; margin: 0 2px; }
        .pagination .page-item.active .page-link { background: var(--crm-red) !important; border-color: var(--crm-red) !important; }
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
                box-shadow: {{ App::getLocale() == 'ar' ? '-6px' : '6px' }} 0 30px rgba(0,0,0,0.18);
            }

            /* Overlay */
            .crm-mob-overlay {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.45);
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
            .crm-topbar { padding: 0 14px; gap: 10px; }

            /* Content padding */
            .crm-content { padding: 14px; }

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
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
            display: flex;
            align-items: center;
            gap: 14px;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            min-width: 320px;
            max-width: 90vw;
            border: 1px solid rgba(0,0,0,0.04);
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
        .crm-toast.success .crm-toast-icon { background: #12B76A; box-shadow: 0 4px 12px rgba(18,183,106,0.3); }
        .crm-toast.error .crm-toast-icon { background: var(--crm-red); box-shadow: 0 4px 12px rgba(227,6,19,0.3); }
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
