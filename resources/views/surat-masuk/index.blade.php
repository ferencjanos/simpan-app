@extends('adminlte::page')

@section('title', 'Surat Masuk')

@section('content_header')
    <h1>Surat Masuk</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
        <a href="{{ route('surat-masuk.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Surat Masuk
        </a>
        <a href="{{ route('surat-masuk.export.excel') }}" class="btn btn-success btn-sm">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        <a href="{{ route('surat-masuk.export.pdf') }}" class="btn btn-danger btn-sm">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        </div>
        <div class="card-body">
            {{-- Form Pencarian --}}
            <form method="GET" action="{{ route('surat-masuk.index') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Cari nomor, pengirim, perihal..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">-- Semua Status --</option>
                            <option value="belum diproses" {{ request('status') == 'belum diproses' ? 'selected' : '' }}>Belum Diproses</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            {{-- Tabel --}}
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Pengirim</th>
                        <th>Perihal</th>
                        <th>Kategori</th>
                        <th>Tanggal Surat</th>
                        <th>Tanggal Terima</th>
                        <th>Status</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratMasuk as $index => $surat)
                    <tr>
                        <td>{{ $suratMasuk->firstItem() + $index }}</td>
                        <td>{{ $surat->nomor_surat }}</td>
                        <td>{{ $surat->pengirim }}</td>
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
                        <td>{{ $surat->tanggal_terima }}</td>
                        <td>
                            @if($surat->status == 'belum diproses')
                                <span class="badge badge-danger">Belum Diproses</span>
                            @elseif($surat->status == 'diproses')
                                <span class="badge badge-warning">Diproses</span>
                            @else
                                <span class="badge badge-success">Selesai</span>
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
                            <a href="{{ route('surat-masuk.show', $surat->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('surat-masuk.edit', $surat->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('disposisi.create', ['surat_masuk_id' => $surat->id]) }}" class="btn btn-sm btn-secondary" title="Disposisi">
                                <i class="fas fa-share-square"></i>
                            </a>
                            <form action="{{ route('surat-masuk.destroy', $surat->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                        <td colspan="9" class="text-center">Tidak ada data surat masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $suratMasuk->links() }}
        </div>
    </div>
@section('js')
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>
@endsection
@stop