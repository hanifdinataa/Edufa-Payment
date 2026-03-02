{{-- resources/views/layouts/admin/header.blade.php --}}
@php
    $isCentre = request()->routeIs('centre.*');
@endphp

<header style="background:#fff;border-bottom:1px solid #eee">
    <div style="max-width:1400px;margin:auto;padding:14px 20px;display:flex;align-items:center">
        
        <!-- Tombol Hamburger -->
        <button class="hamburger" onclick="toggleSidebar()" aria-label="Toggle Menu">
            ☰
        </button>

        <!-- Title -->
        <strong style="color:#800000;font-size:18px">
            {{ $isCentre ? 'Centre Edufa' : 'Edufa Admin' }}
        </strong>

        <div style="margin-left:auto;display:flex;align-items:center;gap:16px">
            <!-- Role -->
            <span style="font-size:14px;color:#555">
                {{ $isCentre ? 'Centre' : 'Administrator' }}
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button style="
                    background:#800000;
                    border:none;
                    color:#fff;
                    padding:6px 14px;
                    border-radius:6px;
                    cursor:pointer">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>
