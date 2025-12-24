{{-- resources/views/admin/siswa/index.blade.php --}}
@extends('layouts.admin.app')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span>›</span>
        <strong>Siswa</strong>
    </div>

    <div class="page-header">
        <div>
            <h2 class="page-title">Data Siswa</h2>
        </div>

        <a href="{{ route('admin.siswa.create') }}" class="btn-add">
            <span class="btn-icon-plus">+</span>
            Tambah Siswa
        </a>
    </div>

    {{-- Desktop Table --}}
    <div class="table-container">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Nama Anak</th>
                    <th>No Induk</th>
                    <th>Orangtua</th>
                    <th>WhatsApp</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($siswas as $siswa)
                    <tr>
                        <td class="strong">{{ $siswa->nama_anak }}</td>
                        <td><span class="badge-code">{{ $siswa->no_induk ?? '-' }}</span></td>
                        <td>{{ $siswa->nama_orangtua }}</td>
                        <td>{{ $siswa->wa }}</td>
                        <td class="aksi">
                            <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="button-edit">
                                <svg viewBox="0 0 512 512" class="svgIcon">
                                    <path
                                        d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z">
                                    </path>
                                </svg>
                            </a>

                            <form method="POST" action="{{ route('admin.siswa.destroy', $siswa->id) }}"
                                style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="button" class="button-delete"
                                    onclick="openDeleteModal({{ $siswa->id }})">
                                    <svg viewBox="0 0 448 512" class="svgIcon">
                                        <path
                                            d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Mobile Card --}}
    <div class="mobile-list">
        @foreach ($siswas as $siswa)
            <div class="siswa-card">
                <div class="card-header">
                    <div class="avatar">{{ substr($siswa->nama_anak, 0, 1) }}</div>
                    <div class="card-main">
                        <div class="name">{{ $siswa->nama_anak }}</div>
                        <div class="meta">{{ $siswa->nama_orangtua }}</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="info-label">No Induk:</span>
                        <span class="badge-code">{{ $siswa->no_induk ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">WhatsApp:</span>
                        <span>{{ $siswa->wa }}</span>
                    </div>
                </div>
                <div class="card-action">
                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="button-edit">
                        <svg viewBox="0 0 512 512" class="svgIcon">
                            <path
                                d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z">
                            </path>
                        </svg>
                    </a>

                    <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="button" class="button-delete" onclick="openDeleteModal({{ $siswa->id }})">
                            <svg viewBox="0 0 448 512" class="svgIcon">
                                <path
                                    d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                </path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    {{-- DELETE MODAL --}}
    <div id="deleteModal" class="modal-overlay" style="display:none;">
        <div class="card">
            <svg id="cookieSvg" viewBox="0 0 122.88 122.25">
                {{-- <path fill="#6b7280"
                    d="M61.44,0A61.46,61.46,0,1,1,18,18,61.21,61.21,0,0,1,61.44,0ZM74.58,36.8c1.74-1.77,2.83-3.18,5-1l7.09,7.09c2.13,2.16.76,3.26-1,5L68.33,65.28,85.67,82.6c1.74,1.77,2.83,3.18,1,5L79.53,94.7c-2.13,2.16-3.42.91-5.15-0.85L57,76.53,39.73,93.85c-1.73,1.77-2.83,3.18-5,1l-7.09-7.09c-2.13-2.16-.76-3.26,1-5L46,65.28,28.64,47.94c-1.74-1.77-2.83-3.18-1-5l7.09-7.09c2.13-2.16,3.42-.91,5.15.85L57,54l17.32-17.32Zm-1.47-15.44a48,48,0,1,0,14.08,33.92,47.91,47.91,0,0,0-14.08-33.92Z">
                </path> --}}
            </svg>

            <p class="cookieHeading">Hapus Siswa?</p>
            <p class="cookieDescription">
                Data siswa yang dihapus tidak bisa dikembalikan.
            </p>

            <div class="buttonContainer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="acceptButton">Hapus</button>
                </form>

                <button class="declineButton" onclick="closeDeleteModal()">Batal</button>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(id) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');

            form.action = `/admin/siswa/${id}`;
            modal.style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }
    </script>

    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-title {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            color: #1a1a1a;
        }

        /* Button Modern */
        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 12px;
            background: linear-gradient(135deg, #800000 0%, #b30000 100%);
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(128, 0, 0, .3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(128, 0, 0, .4);
        }

        .btn-icon-plus {
            font-size: 18px;
            font-weight: 700;
        }

        /* Table Container */
        .table-container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
            overflow: hidden;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .modern-table thead {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        }

        .modern-table th {
            font-size: 12px;
            font-weight: 700;
            color: #6b7280;
            text-align: left;
            padding: 16px;
            border-bottom: 2px solid #e5e7eb;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modern-table td {
            padding: 16px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }

        .modern-table tbody tr {
            transition: all 0.2s ease;
        }

        .modern-table tbody tr:hover {
            background: #f9fafb;
        }

        .strong {
            font-weight: 700;
            color: #1a1a1a;
        }

        .badge-code {
            display: inline-block;
            padding: 4px 10px;
            background: #f3f4f6;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #374151;
            font-weight: 600;
        }

        /* Action Buttons */
        .aksi {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        /* Animated Delete Button */
        .button-delete {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgb(20, 20, 20);
            border: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.164);
            cursor: pointer;
            transition-duration: .3s;
            overflow: hidden;
            position: relative;
        }

        .button-delete .svgIcon {
            width: 12px;
            transition-duration: .3s;
        }

        .button-delete .svgIcon path {
            fill: white;
        }

        .button-delete:hover {
            width: 140px;
            border-radius: 50px;
            transition-duration: .3s;
            background-color: rgb(255, 69, 69);
            align-items: center;
        }

        .button-delete:hover .svgIcon {
            width: 50px;
            transition-duration: .3s;
            transform: translateY(60%);
        }

        .button-delete::before {
            position: absolute;
            top: -20px;
            content: "Delete";
            color: white;
            transition-duration: .3s;
            font-size: 2px;
        }

        .button-delete:hover::before {
            font-size: 13px;
            opacity: 1;
            transform: translateY(30px);
            transition-duration: .3s;
        }

        /* Animated Edit Button */
        .button-edit {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgb(20, 20, 20);
            border: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.164);
            cursor: pointer;
            transition-duration: .3s;
            overflow: hidden;
            position: relative;
            text-decoration: none;
        }

        .button-edit .svgIcon {
            width: 12px;
            transition-duration: .3s;
        }

        .button-edit .svgIcon path {
            fill: white;
        }

        .button-edit:hover {
            width: 140px;
            border-radius: 50px;
            transition-duration: .3s;
            background-color: rgb(53, 116, 255);
            align-items: center;
        }

        .button-edit:hover .svgIcon {
            width: 50px;
            transition-duration: .3s;
            transform: translateY(60%);
        }

        .button-edit::before {
            position: absolute;
            top: -20px;
            content: "Edit";
            color: white;
            transition-duration: .3s;
            font-size: 2px;
        }

        .button-edit:hover::before {
            font-size: 13px;
            opacity: 1;
            transform: translateY(30px);
            transition-duration: .3s;
        }

        /* Mobile Cards */
        .mobile-list {
            display: none;
        }

        .siswa-card {
            background: #fff;
            border-radius: 16px;
            padding: 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
            margin-bottom: 16px;
            border: 1px solid #f3f4f6;
            transition: all 0.3s ease;
        }

        .siswa-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .12);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #800000 0%, #b30000 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
        }

        .card-main .name {
            font-weight: 700;
            font-size: 16px;
            color: #1a1a1a;
            margin-bottom: 2px;
        }

        .card-main .meta {
            font-size: 13px;
            color: #6b7280;
        }

        .card-body {
            padding: 12px 0;
            border-top: 1px solid #f3f4f6;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            font-size: 13px;
        }

        .info-label {
            color: #6b7280;
            font-weight: 600;
        }

        .card-action {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #f3f4f6;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .card {
            width: 300px;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 30px;
            gap: 12px;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
            animation: scaleIn .25s ease;
        }

        @keyframes scaleIn {
            from {
                transform: scale(.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        #cookieSvg {
            width: 50px;
        }

        .cookieHeading {
            font-size: 18px;
            font-weight: 800;
            color: #111;
        }

        .cookieDescription {
            font-size: 13px;
            text-align: center;
            color: #6b7280;
        }

        .buttonContainer {
            display: flex;
            gap: 14px;
            margin-top: 10px;
        }

        .acceptButton {
            padding: 8px 18px;
            background: #dc2626;
            border: none;
            border-radius: 20px;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
        }

        .acceptButton:hover {
            background: #b91c1c;
        }

        .declineButton {
            padding: 8px 18px;
            background: #e5e7eb;
            border: none;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .table-container {
                display: none;
            }

            .mobile-list {
                display: block;
            }
        }
    </style>
@endsection