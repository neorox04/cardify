<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - DBsCard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0066FF;
            --primary-dark: #0052CC;
            --neutral-50: #FAFAFA;
            --neutral-100: #F5F5F5;
            --neutral-200: #E5E5E5;
            --neutral-300: #D4D4D4;
            --neutral-400: #A3A3A3;
            --neutral-500: #737373;
            --neutral-600: #525252;
            --neutral-700: #404040;
            --neutral-800: #262626;
            --neutral-900: #171717;
            --success: #10B981;
            --error: #EF4444;
            --warning: #F59E0B;
            --radius-md: 12px;
            --radius-lg: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Onest', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--neutral-50);
            color: var(--neutral-900);
            -webkit-font-smoothing: antialiased;
            line-height: 1.6;
        }

        .dashboard-layout {
            min-height: 100vh;
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 32px;
            gap: 24px;
        }

        .page-title {
            font-size: 36px;
            font-weight: 700;
            color: var(--neutral-900);
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }

        .page-subtitle {
            font-size: 16px;
            color: var(--neutral-600);
        }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--neutral-200);
            border-radius: var(--radius-lg);
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--neutral-900);
            letter-spacing: -0.02em;
            line-height: 1;
        }

        .stat-label {
            font-size: 14px;
            color: var(--neutral-600);
            margin-top: 4px;
        }

        /* Content */
        .content-section {
            margin-bottom: 40px;
        }

        .section-header {
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--neutral-900);
            letter-spacing: -0.02em;
        }

        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }

        .business-card {
            background: white;
            border: 1px solid var(--neutral-200);
            border-radius: var(--radius-lg);
            padding: 24px;
            transition: all 0.2s;
        }

        .business-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            gap: 12px;
        }

        .card-header h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--neutral-900);
            letter-spacing: -0.01em;
        }

        .card-badge {
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .card-badge.active {
            background: #F0FDF4;
            color: #166534;
            border: 1px solid #86EFAC;
        }

        .card-badge.inactive {
            background: #FEF2F2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        .card-subtitle {
            font-size: 15px;
            color: var(--neutral-700);
            margin-bottom: 4px;
        }

        .card-company {
            font-size: 14px;
            color: var(--neutral-600);
            margin-bottom: 16px;
        }

        .card-stats {
            padding-top: 12px;
            border-top: 1px solid var(--neutral-100);
            margin-bottom: 16px;
        }

        .card-stat {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            color: var(--neutral-600);
        }

        .card-actions {
            display: flex;
            gap: 16px;
            padding-top: 12px;
            border-top: 1px solid var(--neutral-100);
        }

        .btn-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.2s;
        }

        .btn-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border: none;
            border-radius: var(--radius-md);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            font-family: inherit;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.24);
        }

        .btn-secondary {
            background: white;
            color: var(--neutral-900);
            border: 1.5px solid var(--neutral-300);
        }

        .btn-secondary:hover {
            background: var(--neutral-50);
            border-color: var(--neutral-400);
        }

        /* Forms */
        .form-container {
            max-width: 800px;
        }

        .form-section {
            background: white;
            border: 1px solid var(--neutral-200);
            border-radius: var(--radius-lg);
            padding: 32px;
            margin-bottom: 24px;
        }

        .form-section-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--neutral-900);
            margin-bottom: 24px;
            letter-spacing: -0.01em;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--neutral-900);
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            font-size: 15px;
            border: 1.5px solid var(--neutral-300);
            border-radius: var(--radius-md);
            transition: all 0.2s;
            font-family: inherit;
        }

        .form-input:hover {
            border-color: var(--neutral-400);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }

        .form-input.error {
            border-color: var(--error);
        }

        .form-input.error:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .error-message {
            color: var(--error);
            font-size: 13px;
            margin-top: 6px;
            font-weight: 500;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 100px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 14px;
        }

        .checkbox-label input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            padding-top: 24px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 40px;
            background: white;
            border: 1px solid var(--neutral-200);
            border-radius: var(--radius-lg);
        }

        .empty-state svg {
            margin-bottom: 24px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--neutral-900);
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 15px;
            color: var(--neutral-600);
            margin-bottom: 24px;
        }

        /* Detail Views */
        .card-detail {
            background: white;
            border: 1px solid var(--neutral-200);
            border-radius: var(--radius-lg);
            padding: 32px;
            max-width: 800px;
        }

        .detail-section {
            padding-bottom: 24px;
            margin-bottom: 24px;
            border-bottom: 1px solid var(--neutral-200);
        }

        .detail-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .detail-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--neutral-900);
            margin-bottom: 16px;
        }

        .detail-list {
            display: grid;
            gap: 12px;
        }

        .detail-item {
            display: grid;
            grid-template-columns: 140px 1fr;
            gap: 16px;
        }

        .detail-item dt {
            font-size: 14px;
            font-weight: 600;
            color: var(--neutral-600);
        }

        .detail-item dd {
            font-size: 14px;
            color: var(--neutral-900);
        }

        /* Tables */
        .table-container {
            background: white;
            border: 1px solid var(--neutral-200);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background: var(--neutral-50);
        }

        .data-table th {
            text-align: left;
            padding: 16px;
            font-size: 13px;
            font-weight: 700;
            color: var(--neutral-700);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .data-table td {
            padding: 16px;
            font-size: 14px;
            color: var(--neutral-900);
            border-top: 1px solid var(--neutral-200);
        }

        .data-table tbody tr:hover {
            background: var(--neutral-50);
        }

        /* User Menu */
        .user-menu {
            position: fixed;
            top: 24px;
            right: 40px;
            background: white;
            border: 1px solid var(--neutral-200);
            border-radius: var(--radius-md);
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--neutral-900);
        }

        .btn-logout {
            background: none;
            border: none;
            color: var(--neutral-600);
            font-size: 13px;
            cursor: pointer;
            padding: 0;
            text-align: left;
            font-family: inherit;
        }

        .btn-logout:hover {
            color: var(--error);
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-layout {
                padding: 20px;
            }

            .page-title {
                font-size: 28px;
            }

            .dashboard-header {
                flex-direction: column;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .cards-grid {
                grid-template-columns: 1fr;
            }

            .user-menu {
                top: 12px;
                right: 20px;
            }

            .form-section {
                padding: 24px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="dashboard-layout">
        <!-- User Menu -->
        <div class="user-menu">
            <div class="user-avatar">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Terminar sessão</button>
                </form>
            </div>
        </div>

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>