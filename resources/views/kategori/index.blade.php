@extends('adminlte::page')

@section('title', 'Kategori Surat')

@section('content_header')
    <h1>Kategori Surat</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Kategori
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Kategori</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $index => $kategori)
                    <tr>
                        <td>{{ $kategoris->firstItem() + $index }}</td>
                        <td><span class="badge badge-info">{{ $kategori->kode }}</span></td>
                        <td>{{ $kategori->nama }}</td>
                        <td>{{ $kategori->keterangan ?? '-' }}</td>
                        <td>
                            <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data kategori.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $kategoris->links() }}
        </div>
    </div>
@section('js')
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>
@endsection
@stop