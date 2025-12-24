<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Edufa Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('logo-header.png') }}">

    <style>
        :root {
            --maroon:#800000;
            --bg:#f4f6f8;
            --card:#ffffff;
            --text:#333;
        }

        * { box-sizing:border-box; margin:0; padding:0 }

        body {
            font-family: Inter, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        /* LAYOUT */
        .admin-wrapper {
            display:flex;
            min-height:100vh;
            overflow:hidden;
        }

        .main-panel {
            flex:1;
            display:flex;
            flex-direction:column;
            transition: margin-left 0.3s ease;
        }

        .content {
            padding:24px;
        }

        /* HAMBURGER */
        .hamburger {
            font-size:24px;
            background:none;
            border:none;
            cursor:pointer;
            margin-right:12px;
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
            background: rgba(0,0,0,0.5);
            z-index: 199;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* DESKTOP: Sidebar Collapse */
        @media(min-width:769px){
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
        @media(max-width:768px){
            .sidebar {
                position: fixed;
                left: -260px;
                top: 0;
                height: 100vh;
                z-index: 200;
                transition: left 0.3s ease;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            }

            .sidebar.open {
                left: 0;
            }

            .main-panel {
                margin-left: 0 !important;
            }
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
