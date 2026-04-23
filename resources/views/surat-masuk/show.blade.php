@extends('adminlte::page')

@section('title', 'Detail Surat Masuk')

@section('content_header')
    <h1>Detail Surat Masuk</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Nomor Surat</th>
                    <td>{{ $suratMasuk->nomor_surat }}</td>
                </tr>
                <tr>
                    <th>Pengirim</th>
                    <td>{{ $suratMasuk->pengirim }}</td>
                </tr>
                <tr>
                    <th>Perihal</th>
                    <td>{{ $suratMasuk->perihal }}</td>
                </tr>
                <tr>
                    <th>Tanggal Surat</th>
                    <td>{{ $suratMasuk->tanggal_surat }}</td>
                </tr>
                <tr>
                    <th>Tanggal Terima</th>
                    <td>{{ $suratMasuk->tanggal_terima }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($suratMasuk->status == 'belum diproses')
                            <span class="badge badge-danger">Belum Diproses</span>
                        @elseif($suratMasuk->status == 'diproses')
                            <span class="badge badge-warning">Diproses</span>
                        @else
                            <span class="badge badge-success">Selesai</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>File</th>
                    <td>
                        @if($suratMasuk->file)
                            <a href="{{ Storage::url($suratMasuk->file) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-file"></i> Lihat File
                            </a>
                        @else
                            <span class="text-muted">Tidak ada file</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>{{ $suratMasuk->keterangan ?? '-' }}</td>
                </tr>
            </table>
            <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('surat-masuk.edit', $suratMasuk->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@stop