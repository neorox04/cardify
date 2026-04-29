<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Cardifys</title>
    <link rel="icon" type="image/png" href="/icon-192.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#9b6dff">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Cardifys">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=Geist+Mono:wght@400;500&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:           oklch(0.15 0.012 290);
            --bg-2:         oklch(0.19 0.015 290);
            --bg-3:         oklch(0.23 0.018 290);
            --ink:          oklch(0.97 0.010 290);
            --ink-dim:      oklch(0.72 0.015 290);
            --ink-mute:     oklch(0.52 0.012 290);
            --line:         oklch(0.28 0.018 290 / 0.70);
            --line-soft:    oklch(0.28 0.018 290 / 0.35);
            --purple:       oklch(0.72 0.19  300);
            --purple-deep:  oklch(0.52 0.19  300);
            --purple-soft:  oklch(0.72 0.19  300 / 0.12);
            --lavender:     oklch(0.82 0.14  330);
            --amber:        oklch(0.82 0.12   85);
            --green:        oklch(0.78 0.17  160);
            --red:          oklch(0.65 0.22   25);
            --green-soft:   oklch(0.78 0.17  160 / 0.14);
            --red-soft:     oklch(0.65 0.22   25 / 0.14);
            --amber-soft:   oklch(0.82 0.12   85 / 0.14);
            --lavender-soft:oklch(0.82 0.14  330 / 0.12);

            /* Aliases usados pelas páginas filha */
            --bg-primary:    var(--bg);
            --bg-secondary:  var(--bg-2);
            --bg-tertiary:   var(--bg-3);
            --bg-elevated:   oklch(0.27 0.020 290);
            --text-primary:  var(--ink);
            --text-secondary:var(--ink-dim);
            --text-tertiary: var(--ink-mute);
            --border:        var(--line-soft);
            --border-hover:  var(--line);
            --accent:        var(--purple);
            --accent-hover:  var(--lavender);
            --accent-subtle: var(--purple-soft);
            --success:       var(--green);
            --success-subtle:var(--green-soft);
            --error:         var(--red);
            --error-subtle:  var(--red-soft);
            --warning:       var(--amber);
            --warning-subtle:var(--amber-soft);
            --pink:          var(--lavender);
            --pink-subtle:   var(--lavender-soft);
            --purple-subtle: var(--purple-soft);

            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 22px;
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html, body { background: var(--bg); color: var(--ink); }

        body {
            font-family: 'Geist', ui-sans-serif, system-ui, sans-serif;
            font-feature-settings: "ss01", "cv11";
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: "";
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 55% 45% at 90% 15%, oklch(0.72 0.19 300 / 0.07), transparent 60%),
                radial-gradient(ellipse 40% 40% at  5% 85%, oklch(0.82 0.14 330 / 0.04), transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: "";
            position: fixed; inset: 0;
            background-image:
                linear-gradient(to right,  var(--line-soft) 1px, transparent 1px),
                linear-gradient(to bottom, var(--line-soft) 1px, transparent 1px);
            background-size: 72px 72px;
            background-position: -1px -1px;
            mask-image: radial-gradient(ellipse 60% 100% at 20% center, rgba(0,0,0,0.35), transparent 70%);
            pointer-events: none;
            z-index: 0;
            opacity: 0.35;
        }

        /* ─── Layout ──────────────────────────────────────── */
        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* ─── Sidebar ─────────────────────────────────────── */
        .sidebar {
            width: 252px;
            background: oklch(0.17 0.013 290 / 0.90);
            border-right: 1px solid var(--line-soft);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 22px 14px;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Brand */
        .sidebar-brand { margin-bottom: 28px; padding: 0 10px; }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 17px;
            font-weight: 600;
            letter-spacing: -0.01em;
            text-decoration: none;
            color: var(--ink);
        }

        .logo .mark {
            width: 28px; height: 28px;
            border-radius: 8px;
            flex-shrink: 0;
            box-shadow: 0 0 16px oklch(0.72 0.19 300 / 0.38);
        }

        /* Nav */
        .sidebar-nav { flex: 1; overflow-y: auto; }

        .nav-section { margin-bottom: 22px; }

        .nav-section-title {
            font-family: 'Geist Mono', monospace;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ink-mute);
            margin-bottom: 6px;
            padding: 0 10px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 10px;
            border: 1px solid transparent;
            color: var(--ink-dim);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: var(--transition);
            margin-bottom: 2px;
            position: relative;
        }

        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; opacity: 0.75; }

        .nav-item:hover {
            background: oklch(0.72 0.19 300 / 0.06);
            color: var(--ink);
        }

        .nav-item:hover svg { opacity: 1; }

        .nav-item.active {
            background: oklch(0.72 0.19 300 / 0.11);
            border-color: oklch(0.72 0.19 300 / 0.22);
            color: var(--purple);
        }

        .nav-item.active svg { opacity: 1; }

        .nav-item.active::before {
            content: "";
            position: absolute;
            left: -14px; top: 50%;
            width: 3px; height: 16px;
            background: var(--purple);
            border-radius: 0 2px 2px 0;
            transform: translateY(-50%);
            box-shadow: 1px 0 8px oklch(0.72 0.19 300 / 0.5);
        }

        .nav-badge {
            margin-left: auto;
            background: var(--purple);
            color: oklch(0.15 0.02 290);
            font-family: 'Geist Mono', monospace;
            font-size: 10px;
            font-weight: 700;
            padding: 1px 7px;
            border-radius: 999px;
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding-top: 16px;
            border-top: 1px solid var(--line-soft);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 12px;
            background: oklch(0.21 0.016 290 / 0.55);
            border: 1px solid var(--line-soft);
        }

        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--purple), var(--lavender));
            color: oklch(0.15 0.02 290);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            flex-shrink: 0;
        }

        .user-info { flex: 1; min-width: 0; }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--ink);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-email {
            font-family: 'Geist Mono', monospace;
            font-size: 10.5px;
            color: var(--ink-mute);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .logout-form { margin-top: 8px; }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            width: 100%;
            padding: 8px 14px;
            border-radius: 10px;
            background: transparent;
            border: 1px solid var(--line-soft);
            color: var(--ink-mute);
            font-family: inherit;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-logout:hover {
            background: oklch(0.65 0.22 25 / 0.09);
            border-color: oklch(0.65 0.22 25 / 0.35);
            color: var(--red);
        }

        .btn-logout svg { width: 15px; height: 15px; }

        /* ─── Main content ────────────────────────────────── */
        .main-content {
            flex: 1;
            margin-left: 252px;
            padding: 32px 40px;
            min-height: 100vh;
        }

        /* Topbar */
        .topbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 24px;
            min-height: 1px;
        }

        /* Page header */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 28px;
            gap: 20px;
            flex-wrap: wrap;
        }

        .page-title {
            font-size: 26px;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: -0.025em;
            line-height: 1.1;
            margin-bottom: 4px;
        }

        .page-subtitle { font-size: 14px; color: var(--ink-dim); }

        /* ─── Alerts ──────────────────────────────────────── */
        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 16px;
            border-radius: var(--radius-md);
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        .alert-success {
            background: var(--green-soft);
            color: var(--green);
            border: 1px solid oklch(0.78 0.17 160 / 0.28);
        }

        .alert-error {
            background: var(--red-soft);
            color: var(--red);
            border: 1px solid oklch(0.65 0.22 25 / 0.28);
        }

        /* ─── Stats grid ──────────────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 14px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: oklch(0.18 0.014 290 / 0.65);
            border: 1px solid var(--line-soft);
            border-radius: var(--radius-xl);
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: border-color .25s, transform .25s;
            backdrop-filter: blur(10px);
        }

        .stat-card:hover {
            border-color: oklch(0.72 0.19 300 / 0.30);
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 46px; height: 46px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon svg { width: 20px; height: 20px; }

        /* Colour variants */
        .stat-icon.blue,
        .stat-icon.purple { background: var(--purple-soft);   color: var(--purple);  }
        .stat-icon.green  { background: var(--green-soft);    color: var(--green);   }
        .stat-icon.yellow { background: var(--amber-soft);    color: var(--amber);   }
        .stat-icon.pink   { background: var(--lavender-soft); color: var(--lavender);}

        .stat-value {
            font-size: 28px;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: -0.03em;
            line-height: 1;
            font-feature-settings: "tnum";
        }

        .stat-label { font-size: 13px; color: var(--ink-dim); margin-top: 3px; }

        /* ─── Content sections ────────────────────────────── */
        .content-section { margin-bottom: 28px; }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: -0.015em;
        }

        /* ─── Cards grid ──────────────────────────────────── */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 14px;
        }

        .business-card {
            background: oklch(0.18 0.014 290 / 0.65);
            border: 1px solid var(--line-soft);
            border-radius: var(--radius-xl);
            padding: 20px;
            transition: border-color .25s, transform .25s;
            backdrop-filter: blur(10px);
            cursor: pointer;
        }

        .business-card:hover {
            border-color: oklch(0.72 0.19 300 / 0.30);
            transform: translateY(-2px);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
            gap: 8px;
        }

        .card-header h3 {
            font-size: 15px;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: -0.01em;
        }

        .card-badge {
            padding: 3px 9px;
            border-radius: 999px;
            font-family: 'Geist Mono', monospace;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .card-badge.active   { background: var(--green-soft);  color: var(--green); border: 1px solid oklch(0.78 0.17 160 / 0.22); }
        .card-badge.inactive { background: var(--red-soft);    color: var(--red);   border: 1px solid oklch(0.65 0.22 25  / 0.22); }

        .card-subtitle  { font-size: 13.5px; color: var(--ink-dim);  margin-bottom: 3px; }
        .card-company   { font-family: 'Geist Mono', monospace; font-size: 11.5px; color: var(--ink-mute); margin-bottom: 12px; }

        .card-stats {
            padding-top: 12px;
            border-top: 1px solid var(--line-soft);
            margin-bottom: 12px;
        }

        .card-stat {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: var(--ink-dim);
        }

        .card-stat svg { width: 13px; height: 13px; }

        .card-actions {
            display: flex;
            gap: 14px;
            padding-top: 12px;
            border-top: 1px solid var(--line-soft);
        }

        .btn-link {
            color: var(--purple);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: color .2s;
        }

        .btn-link:hover { color: var(--lavender); }

        /* ─── Buttons ─────────────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 13.5px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: transform .15s ease, background .2s, box-shadow .2s, border-color .2s;
            text-decoration: none;
            line-height: 1;
        }

        .btn svg { width: 15px; height: 15px; }

        .btn-primary {
            background: var(--purple);
            color: oklch(0.15 0.02 290);
            box-shadow: 0 6px 20px oklch(0.72 0.19 300 / 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 28px oklch(0.72 0.19 300 / 0.38);
        }

        .btn-secondary {
            background: oklch(0.22 0.016 290 / 0.65);
            color: var(--ink);
            border-color: var(--line-soft);
            backdrop-filter: blur(8px);
        }

        .btn-secondary:hover {
            background: oklch(0.26 0.018 290 / 0.75);
            border-color: var(--line);
        }

        .btn-danger {
            background: var(--red-soft);
            color: var(--red);
            border-color: oklch(0.65 0.22 25 / 0.22);
        }

        .btn-danger:hover {
            background: var(--red);
            color: #fff;
            border-color: transparent;
        }

        /* ─── Forms ───────────────────────────────────────── */
        .form-container { max-width: 780px; }

        .form-section {
            background: oklch(0.18 0.014 290 / 0.65);
            border: 1px solid var(--line-soft);
            border-radius: var(--radius-xl);
            padding: 26px;
            margin-bottom: 18px;
            backdrop-filter: blur(10px);
        }

        .form-section-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 18px;
            letter-spacing: -0.01em;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 14px;
        }

        .form-group { margin-bottom: 14px; }

        .form-label {
            display: block;
            font-family: 'Geist Mono', monospace;
            font-size: 10.5px;
            font-weight: 500;
            letter-spacing: 0.10em;
            text-transform: uppercase;
            color: var(--ink-mute);
            margin-bottom: 7px;
        }

        .form-input {
            width: 100%;
            padding: 11px 13px;
            font-size: 14px;
            font-family: inherit;
            background: oklch(0.13 0.010 290 / 0.75);
            border: 1px solid var(--line-soft);
            border-radius: var(--radius-md);
            color: var(--ink);
            transition: var(--transition);
        }

        .form-input::placeholder { color: var(--ink-mute); }
        .form-input:hover  { border-color: var(--line); }
        .form-input:focus  {
            outline: none;
            border-color: var(--purple);
            box-shadow: 0 0 0 3px oklch(0.72 0.19 300 / 0.14);
        }
        .form-input.error  { border-color: var(--red); }

        .error-message {
            color: var(--red);
            font-size: 12px;
            margin-top: 5px;
            font-weight: 500;
        }

        textarea.form-input { resize: vertical; min-height: 100px; }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 14px;
            color: var(--ink-dim);
        }

        .checkbox-label input[type="checkbox"] {
            width: 15px; height: 15px;
            cursor: pointer;
            accent-color: var(--purple);
        }

        .form-actions { display: flex; gap: 10px; padding-top: 18px; }

        /* ─── Empty state ─────────────────────────────────── */
        .empty-state {
            text-align: center;
            padding: 64px 40px;
            background: oklch(0.18 0.014 290 / 0.65);
            border: 1px solid var(--line-soft);
            border-radius: var(--radius-xl);
            backdrop-filter: blur(10px);
        }

        .empty-state svg      { margin-bottom: 18px; color: var(--ink-mute); }
        .empty-state h3       { font-size: 17px; font-weight: 600; color: var(--ink); margin-bottom: 6px; }
        .empty-state p        { font-size: 14px; color: var(--ink-dim); margin-bottom: 22px; }

        /* ─── Detail view ─────────────────────────────────── */
        .card-detail {
            background: oklch(0.18 0.014 290 / 0.65);
            border: 1px solid var(--line-soft);
            border-radius: var(--radius-xl);
            padding: 26px;
            max-width: 780px;
            backdrop-filter: blur(10px);
        }

        .detail-section {
            padding-bottom: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--line-soft);
        }
        .detail-section:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }

        .detail-title {
            font-family: 'Geist Mono', monospace;
            font-size: 10.5px;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--ink-mute);
            margin-bottom: 14px;
        }

        .detail-list  { display: grid; gap: 10px; }

        .detail-item  { display: grid; grid-template-columns: 130px 1fr; gap: 12px; }
        .detail-item dt { font-size: 13px; font-weight: 500; color: var(--ink-mute); }
        .detail-item dd { font-size: 13px; color: var(--ink); }

        /* ─── Tables ──────────────────────────────────────── */
        .table-container {
            background: oklch(0.18 0.014 290 / 0.65);
            border: 1px solid var(--line-soft);
            border-radius: var(--radius-xl);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .data-table { width: 100%; border-collapse: collapse; }

        .data-table thead {
            background: oklch(0.21 0.016 290 / 0.55);
            border-bottom: 1px solid var(--line-soft);
        }

        .data-table th {
            text-align: left;
            padding: 12px 16px;
            font-family: 'Geist Mono', monospace;
            font-size: 10px;
            font-weight: 500;
            color: var(--ink-mute);
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .data-table td {
            padding: 13px 16px;
            font-size: 13px;
            color: var(--ink);
            border-top: 1px solid var(--line-soft);
        }

        .data-table tbody tr { transition: background .15s; }
        .data-table tbody tr:hover { background: oklch(0.72 0.19 300 / 0.05); }

        /* ─── Mobile sidebar ──────────────────────────────── */
        .mobile-toggle {
            display: none;
            position: fixed;
            bottom: 24px; right: 24px;
            width: 50px; height: 50px;
            border-radius: 50%;
            background: var(--purple);
            color: oklch(0.15 0.02 290);
            border: none;
            cursor: pointer;
            z-index: 200;
            box-shadow: 0 4px 18px oklch(0.72 0.19 300 / 0.4);
            align-items: center;
            justify-content: center;
        }

        .mobile-toggle svg { width: 20px; height: 20px; }

        /* ─── Responsive ──────────────────────────────────── */
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 20px; }
            .mobile-toggle { display: flex; }
            .page-title { font-size: 22px; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .cards-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .stats-grid { grid-template-columns: 1fr; }
            .dashboard-header { flex-direction: column; align-items: flex-start; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="dashboard-wrapper">

    <!-- ── Sidebar ──────────────────────────────────────── -->
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-brand">
            <a href="{{ route('home') }}" class="logo">
                <img src="/icon.svg" alt="Cardify" class="mark">
                Cardifys
            </a>
        </div>

        <nav class="sidebar-nav">

            <div class="nav-section">
                <div class="nav-section-title">Menu</div>

                <a href="{{ route('dashboard') }}"
                   class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('business-cards.index') }}"
                   class="nav-item {{ request()->routeIs('business-cards.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="2" y="5" width="20" height="14" rx="3" stroke="currentColor" stroke-width="1.8" fill="none"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2 10h20"/>
                    </svg>
                    Cartões
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Conta</div>

                <a href="{{ route('user.profile') }}"
                   class="nav-item {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Perfil
                </a>

                <a href="{{ route('user.invites') }}"
                   class="nav-item {{ request()->routeIs('user.invites') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Convites
                    @php
                        $pendingInvitesCount = \App\Models\CompanyInvite::forEmail(auth()->user()->email)->pending()->count();
                    @endphp
                    @if($pendingInvitesCount > 0)
                        <span class="nav-badge">{{ $pendingInvitesCount }}</span>
                    @endif
                </a>
            </div>

            @if(Auth::user()->isCompanyAdmin())
            <div class="nav-section">
                <div class="nav-section-title">Empresa</div>

                <a href="{{ route('company.dashboard') }}"
                   class="nav-item {{ request()->routeIs('company.*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Painel Empresa
                </a>

                <a href="{{ route('subscriptions.seats') }}"
                   class="nav-item {{ request()->routeIs('subscriptions.seats*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Colaboradores
                </a>
            </div>
            @endif

            @if(Auth::user()->isSuperAdmin())
            <div class="nav-section">
                <div class="nav-section-title">Administração</div>

                <a href="{{ route('admin.dashboard') }}"
                   class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Admin
                </a>

                <a href="{{ route('admin.analytics') }}"
                   class="nav-item {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Analytics
                </a>

                <a href="{{ route('admin.companies') }}"
                   class="nav-item {{ request()->routeIs('admin.companies*') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Empresas
                </a>

                <a href="{{ route('admin.users') }}"
                   class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Utilizadores
                </a>

                <a href="{{ route('admin.business-cards') }}"
                   class="nav-item {{ request()->routeIs('admin.business-cards') ? 'active' : '' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="2" y="5" width="20" height="14" rx="3" stroke="currentColor" stroke-width="1.8" fill="none"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2 10h20"/>
                    </svg>
                    Todos os Cartões
                </a>
            </div>
            @endif

        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-email">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Terminar Sessão
                </button>
            </form>
        </div>

    </aside>

    <!-- ── Main content ──────────────────────────────────── -->
    <main class="main-content">

        <div class="topbar"></div>

        @if(session('success'))
            <div class="alert alert-success">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')

    </main>
</div>

<!-- Mobile toggle -->
<button class="mobile-toggle" id="mobile-toggle" aria-label="Abrir menu">
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
</button>

<script>
    const mobileToggle = document.getElementById('mobile-toggle');
    const sidebar      = document.getElementById('sidebar');
    mobileToggle.addEventListener('click', () => sidebar.classList.toggle('open'));
    document.addEventListener('click', e => {
        if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target))
            sidebar.classList.remove('open');
    });
</script>
@stack('scripts')
<script>
    if ('serviceWorker' in navigator)
        window.addEventListener('load', () => navigator.serviceWorker.register('/service-worker.js').catch(() => {}));
</script>
</body>
</html>
