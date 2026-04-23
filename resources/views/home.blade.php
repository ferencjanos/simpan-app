@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        {{-- Total Surat Masuk --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalSuratMasuk }}</h3>
                    <p>Total Surat Masuk</p>
                </div>
                <div class="icon"><i class="fas fa-envelope-open"></i></div>
                <a href="{{ url('surat-masuk') }}" class="small-box-footer">Lihat Semua <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- Total Surat Keluar --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalSuratKeluar }}</h3>
                    <p>Total Surat Keluar</p>
                </div>
                <div class="icon"><i class="fas fa-envelope"></i></div>
                <a href="{{ url('surat-keluar') }}" class="small-box-footer">Lihat Semua <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- Surat Masuk Belum Diproses --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $suratMasukBelumDiproses }}</h3>
                    <p>Belum Diproses</p>
                </div>
                <div class="icon"><i class="fas fa-clock"></i></div>
                <a href="{{ url('surat-masuk?status=belum diproses') }}" class="small-box-footer">Lihat Semua <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- Surat Masuk Selesai --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $suratMasukSelesai }}</h3>
                    <p>Surat Selesai</p>
                </div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
                <a href="{{ url('surat-masuk?status=selesai') }}" class="small-box-footer">Lihat Semua <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Surat Masuk Terbaru --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Surat Masuk Terbaru</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Pengirim</th>
                                <th>Perihal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suratMasukTerbaru as $surat)
                            <tr>
                                <td>{{ $surat->nomor_surat }}</td>
                                <td>{{ $surat->pengirim }}</td>
                                <td>{{ Str::limit($surat->perihal, 30) }}</td>
                                <td>
                                    @if($surat->status == 'belum diproses')
                                        <span class="badge badge-danger">Belum Diproses</span>
                                    @elseif($surat->status == 'diproses')
                                        <span class="badge badge-warning">Diproses</span>
                                    @else
                                        <span class="badge badge-success">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Surat Keluar Terbaru --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Surat Keluar Terbaru</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tujuan</th>
                                <th>Perihal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suratKeluarTerbaru as $surat)
                            <tr>
                                <td>{{ $surat->nomor_surat }}</td>
                                <td>{{ $surat->tujuan }}</td>
                                <td>{{ Str::limit($surat->perihal, 30) }}</td>
                                <td>
                                    @if($surat->status == 'draft')
                                        <span class="badge badge-warning">Draft</span>
                                    @else
                                        <span class="badge badge-success">Terkirim</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@section('js')
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>
@endsection    
@stop