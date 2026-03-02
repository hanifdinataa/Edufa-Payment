{{-- resources/views/layouts/admin/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Edufa Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('logo-header.png') }}">

    <style>
        :root {
            --maroon: #800000;
            --bg: #f4f6f8;
            --card: #ffffff;
            --text: #333;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        body {
            font-family: Inter, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        /* LAYOUT */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        .main-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        .content {
            padding: 24px;
        }

        /* HAMBURGER */
        .hamburger {
            font-size: 24px;
            background: none;
            border: none;
            cursor: pointer;
            margin-right: 12px;
            color: var(--maroon);
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            border-radius: 6px;
        }

        .hamburger:hover {
            background: rgba(128, 0, 0, 0.1);
        }

        /* OVERLAY untuk Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 199;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* DESKTOP: Sidebar Collapse */
        @media(min-width:769px) {
            .sidebar.collapsed {
                width: 70px !important;
            }

            .sidebar.collapsed .logo strong {
                font-size: 16px;
                writing-mode: vertical-rl;
                text-orientation: upright;
            }

            .sidebar.collapsed nav a span:not(.menu-icon) {
                opacity: 0;
                visibility: hidden;
                width: 0;
            }

            .sidebar.collapsed nav a {
                justify-content: center;
                padding: 10px 0;
            }

            .sidebar.collapsed nav a .menu-icon {
                margin-right: 0;
            }
        }

        /* MOBILE: Sidebar Hidden by Default */
        @media(max-width:768px) {
            .sidebar {
                position: fixed;
                left: -260px;
                top: 0;
                height: 100vh;
                z-index: 200;
                transition: left 0.3s ease;
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            }

            .sidebar.open {
                left: 0;
            }

            .main-panel {
                margin-left: 0 !important;
            }
        }

        .page-wrapper {
            padding: 10px 0;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .page-header h2 {
            font-size: 22px;
            font-weight: 700;
            color: #222;
        }

        .card {
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
            transition: 0.2s;
        }

        .form-group input:focus {
            border-color: #800000;
            outline: none;
        }

        .form-actions {
            margin-top: 20px;
        }

        .btn-primary {
            background: #800000;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-primary:hover {
            background: #a00000;
        }

        .btn-secondary {
            background: #eee;
            color: #333;
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
        }

        .table-custom th {
            text-align: left;
            padding: 12px;
            background: #f5f5f5;
            font-size: 13px;
        }

        .table-custom td {
            padding: 12px;
            border-top: 1px solid #eee;
            font-size: 14px;
        }

        .btn-small {
            background: #f4f6f8;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            text-decoration: none;
            margin-right: 6px;
        }

        .btn-danger {
            background: #fee2e2;
            color: #991b1b;
            border: none;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            border: 1px solid #a7f3d0;
            font-size: 14px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Table styling upgrade */

        .table-custom {
            width: 100%;
            border-collapse: collapse;
        }

        .table-custom thead {
            background: #f9fafb;
        }

        .table-custom th {
            text-align: left;
            padding: 14px 16px;
            font-size: 13px;
            font-weight: 700;
            color: #555;
            border-bottom: 1px solid #eee;
        }

        .table-custom td {
            padding: 14px 16px;
            font-size: 14px;
            border-bottom: 1px solid #f1f1f1;
        }

        .table-custom tbody tr:hover {
            background: #fafafa;
        }

        .badge-cabang {
            background: #f4f6f8;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: #800000;
        }

        .empty-text {
            text-align: center;
            padding: 20px;
            color: #777;
            font-size: 14px;
        }

        /* Breadcrumb & title consistent */
        .breadcrumb {
            font-size: 13px;
            color: #777;
            margin-bottom: 12px;
        }

        .breadcrumb a {
            color: #777;
            text-decoration: none;
        }

        .breadcrumb span {
            margin: 0 6px;
        }

        .breadcrumb strong {
            color: #800000;
            font-weight: 600;
        }

        .page-title {
            margin: 8px 0 20px;
            font-size: 22px;
            font-weight: 700;
            color: #222;
        }

        .page-wrapper {
            padding-bottom: 40px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card {
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #800000;
            outline: none;
        }

        .form-actions {
            margin-top: 20px;
        }

        .btn-primary {
            background: #800000;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: #a00000;
        }

        .btn-secondary {
            background: #eee;
            color: #333;
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
        }

        .table-custom th {
            text-align: left;
            padding: 12px;
            background: #f5f5f5;
            font-size: 13px;
        }

        .table-custom td {
            padding: 12px;
            border-top: 1px solid #eee;
            font-size: 14px;
        }

        .table-custom tr:hover {
            background: #fafafa;
        }

        .btn-small {
            background: #f4f6f8;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            text-decoration: none;
            margin-right: 6px;
        }

        .btn-danger {
            background: #fee2e2;
            color: #991b1b;
            border: none;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
        }

        .empty-text {
            text-align: center;
            padding: 20px;
            color: #777;
        }

        /* Filter Card */
        .filter-card {
            background: #fff;
            padding: 16px 20px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .filter-row {
            display: flex;
            gap: 16px;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            font-size: 12px;
            margin-bottom: 6px;
            color: #555;
        }

        .filter-group select,
        .filter-group input {
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 13px;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            border-color: #800000;
            outline: none;
        }
    </style>
</head>

<body>

    <div class="admin-wrapper">

        @include('layouts.admin.sidebar')

        <!-- Overlay untuk Mobile -->
        <div class="sidebar-overlay" onclick="closeSidebarMobile()"></div>

        <div class="main-panel">
            @include('layouts.admin.header')

            <div class="content">
                @yield('content')
            </div>
        </div>

    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            const isMobile = window.innerWidth <= 768;

            if (isMobile) {
                // Mobile: Slide in/out
                sidebar.classList.toggle('open');
                overlay.classList.toggle('active');
            } else {
                // Desktop: Collapse/Expand
                sidebar.classList.toggle('collapsed');
            }
        }

        function closeSidebarMobile() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');

            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        }

        // Handle resize
        window.addEventListener('resize', function() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');

            if (window.innerWidth > 768) {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            }
        });
    </script>

</body>

</html>
