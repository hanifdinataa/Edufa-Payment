<aside class="sidebar">

    @php
        $isCentre = request()->routeIs('centre.*');
    @endphp

    <nav>

        {{-- ===================== --}}
        {{-- SIDEBAR CENTRE --}}
        {{-- ===================== --}}
        @if ($isCentre)

            <a href="{{ route('centre.dashboard') }}"
               class="{{ request()->routeIs('centre.dashboard') ? 'active' : '' }}">
                <span class="menu-icon">🏠</span>
                <span>Beranda</span>
            </a>

            <a href="{{ route('centre.laporan.index') }}"
               class="{{ request()->routeIs('centre.laporan.*') ? 'active' : '' }}">
                <span class="menu-icon">📑</span>
                <span>Laporan Cabang</span>
            </a>

        {{-- ===================== --}}
        {{-- SIDEBAR ADMIN --}}
        {{-- ===================== --}}
        @else

            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="menu-icon">📊</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.siswa.index') }}"
               class="{{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                <span class="menu-icon">👨‍🎓</span>
                <span>Siswa</span>
            </a>

            <a href="{{ route('admin.invoice.index') }}"
               class="{{ request()->routeIs('admin.invoice.*') ? 'active' : '' }}">
                <span class="menu-icon">🧾</span>
                <span>Invoice</span>
            </a>

        @endif

    </nav>

    <style>
        .sidebar {
            width: 240px;
            background: #fff;
            border-right: 1px solid #eee;
            padding: 20px;
            display: flex;
            flex-direction: column;
            transition: width 0.3s ease, left 0.3s ease;
        }

        nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        nav a {
            padding: 12px 14px;
            border-radius: 8px;
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
            position: relative;
        }

        nav a .menu-icon {
            font-size: 20px;
            min-width: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        nav a span:not(.menu-icon) {
            white-space: nowrap;
        }

        nav a.active {
            background: #f4f6f8;
            font-weight: 700;
            color: #800000;
        }

        nav a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: #800000;
            border-radius: 0 4px 4px 0;
        }

        nav a:hover {
            background: #f4f6f8;
        }

        @media(max-width: 768px) {
            .sidebar {
                width: 260px;
            }
        }
    </style>

</aside>
