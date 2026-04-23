@extends('adminlte::page')

@section('title', 'Surat Keluar')

@section('content_header')
    <h1>Surat Keluar</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
        <a href="{{ route('surat-keluar.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Surat Keluar
        </a>
        <a href="{{ route('surat-keluar.export.excel') }}" class="btn btn-success btn-sm">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        <a href="{{ route('surat-keluar.export.pdf') }}" class="btn btn-danger btn-sm">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        </div>
        <div class="card-body">
            {{-- Form Pencarian --}}
            <form method="GET" action="{{ route('surat-keluar.index') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Cari nomor, tujuan, perihal..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">-- Semua Status --</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="terkirim" {{ request('status') == 'terkirim' ? 'selected' : '' }}>Terkirim</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            {{-- Tabel --}}
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Tujuan</th>
                        <th>Perihal</th>
                        <th>Kategori</th>
                        <th>Tanggal Surat</th>
                        <th>Status</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratKeluar as $index => $surat)
                    <tr>
                        <td>{{ $suratKeluar->firstItem() + $index }}</td>
                        <td>{{ $surat->nomor_surat }}</td>
                        <td>{{ $surat->tujuan }}</td>
                        <td>{{ $surat->perihal }}</td>
                        <td>
                            @if($surat->kategori)
                                <span class="badge badge-info">{{ $surat->kategori->kode }}</span>
                                {{ $surat->kategori->nama }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $surat->tanggal_surat }}</td>
                        <td>
                            @if($surat->status == 'draft')
                                <span class="badge badge-warning">Draft</span>
                            @else
                                <span class="badge badge-success">Terkirim</span>
                            @endif
                        </td>
                        <td>
                            @if($surat->file)
                                <a href="{{ Storage::url($surat->file) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-file"></i> Lihat
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('surat-keluar.show', $surat->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('surat-keluar.edit', $surat->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('surat-keluar.destroy', $surat->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                        <td colspan="8" class="text-center">Tidak ada data surat keluar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $suratKeluar->links() }}
        </div>
    </div>
@section('js')
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>
@endsection
@stop