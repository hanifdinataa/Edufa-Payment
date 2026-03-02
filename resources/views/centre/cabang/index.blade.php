@extends('layouts.admin.app')

@section('content')
    <div class="page-wrapper">

        <div class="page-header">
            <h2>Management Cabang</h2>
            <a href="{{ route('centre.cabang.create') }}" class="btn-primary">
                + Tambah Cabang
            </a>
        </div>

        <div class="card">
            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Nama Cabang</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cabangs as $cabang)
                        <tr>
                            <td>{{ $cabang->nama_cabang }}</td>
                            <td>
                                <a href="{{ route('centre.cabang.edit', $cabang->id) }}" class="btn-small">
                                    Edit
                                </a>

                                <form action="{{ route('centre.cabang.destroy', $cabang->id) }}" method="POST"
                                    style="display:inline;" onsubmit="return confirmDelete(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">Belum ada cabang</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
    <script>
        function confirmDelete(event) {
            event.preventDefault();

            if (confirm("Yakin ingin menghapus cabang ini?")) {
                event.target.submit();
            }

            return false;
        }
    </script>
@endsection
