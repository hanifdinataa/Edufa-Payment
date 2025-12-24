<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Edufa Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('logo-header.png') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

    <style>
        :root {
            --maroon: #800000;
            --bg: #f4f6f8;
            --card: #ffffff;
            --text: #333;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Inter, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        /* ================= HEADER ================= */
        header {
            background: var(--maroon);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav {
            max-width: 1200px;
            margin: auto;
            padding: 14px 20px;
            display: flex;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        /* ================= NAV GROUP ================= */
        .nav-links {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .logout-menu {
            margin-left: auto; /* DESKTOP: dorong ke kanan */
        }

        .logout-menu button {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.6);
            color: white;
            padding: 6px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        .logout-menu button:hover {
            background: white;
            color: var(--maroon);
        }

        /* ================= HAMBURGER ================= */
        .hamburger {
            display: none;
            margin-left: auto;
            flex-direction: column;
            gap: 4px;
            cursor: pointer;
        }

        .hamburger span {
            width: 22px;
            height: 2px;
            background: white;
        }

        /* ================= OVERLAY ================= */
        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            opacity: 0;
            visibility: hidden;
            transition: 0.3s;
            z-index: 150;
        }

        .overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* ================= MAIN ================= */
        main {
            padding: 24px 16px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: var(--card);
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.05);
            opacity: 0;
            transform: translateY(20px);
        }

        /* ================= MOBILE ================= */
        @media (max-width: 768px) {
            .nav-links {
                position: fixed;
                top: 0;
                left: -260px;
                width: 260px;
                height: 100vh;
                background: var(--maroon);
                flex-direction: column;
                align-items: stretch;
                padding: 24px 20px;
                gap: 16px;
                transition: left 0.35s ease;
                z-index: 200; /* LEBIH TINGGI DARI OVERLAY */
                pointer-events: auto;
            }

            .nav-links.active {
                left: 0;
            }

            .logout-menu {
                margin-left: 0;
                margin-top: 20px;
            }

            .logout-menu button {
                width: 100%;
            }

            .hamburger {
                display: flex;
            }
        }
    </style>
</head>
<body>

<header>
    <nav>
        <div class="nav-links" id="navMenu">
            @auth
                @if(auth()->user()->role === 'CABANG')
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a href="{{ route('admin.siswa.index') }}">Siswa</a>
                    <a href="{{ route('admin.invoice.index') }}">Invoice</a>
                @endif

                @if(auth()->user()->role === 'CENTRE')
                    <a href="{{ route('centre.dashboard') }}">Dashboard</a>
                    <a href="{{ route('centre.laporan.index') }}">Laporan</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="logout-menu">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @endauth
        </div>

        <div class="hamburger" id="hamburger">
            <span></span><span></span><span></span>
        </div>
    </nav>
</header>

<div class="overlay" id="overlay"></div>

<main>
    <div class="container" id="pageContainer">
        @yield('content')
    </div>
</main>

<script>
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('navMenu');
    const overlay = document.getElementById('overlay');

    hamburger.addEventListener('click', () => {
        navMenu.classList.add('active');
        overlay.classList.add('active');

        anime({
            targets: '#navMenu a, .logout-menu',
            translateX: [-20, 0],
            opacity: [0, 1],
            delay: anime.stagger(60),
            easing: 'easeOutQuad'
        });
    });

    overlay.addEventListener('click', () => {
        navMenu.classList.remove('active');
        overlay.classList.remove('active');
    });

    anime({
        targets: '#pageContainer',
        opacity: [0, 1],
        translateY: [20, 0],
        duration: 600,
        easing: 'easeOutExpo'
    });
</script>

</body>
</html>
