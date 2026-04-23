@extends('adminlte::page')

@section('title', 'Disposisi Surat')

@section('content_header')
    <h1>Disposisi Surat</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{ route('disposisi.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Buat Disposisi
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Surat Masuk</th>
                        <th>Dari</th>
                        <th>Kepada</th>
                        <th>Instruksi</th>
                        <th>Batas Waktu</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($disposisis as $index => $disposisi)
                    <tr>
                        <td>{{ $disposisis->firstItem() + $index }}</td>
                        <td>{{ $disposisi->suratMasuk->nomor_surat ?? '-' }}<br>
                            <small class="text-muted">{{ $disposisi->suratMasuk->perihal ?? '' }}</small>
                        </td>
                        <td>{{ $disposisi->dariUser->name ?? '-' }}</td>
                        <td>{{ $disposisi->kepadaUser->name ?? '-' }}</td>
                        <td>{{ Str::limit($disposisi->instruksi, 50) }}</td>
                        <td>{{ $disposisi->batas_waktu ?? '-' }}</td>
                        <td>
                            @if($disposisi->status == 'belum dibaca')
                                <span class="badge badge-danger">Belum Dibaca</span>
                            @elseif($disposisi->status == 'sudah dibaca')
                                <span class="badge badge-warning">Sudah Dibaca</span>
                            @else
                                <span class="badge badge-success">Selesai</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('disposisi.show', $disposisi->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('disposisi.destroy', $disposisi->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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
                        <td colspan="8" class="text-center">Tidak ada data disposisi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $disposisis->links() }}
        </div>
    </div>
@section('js')
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>
@endsection
@stop