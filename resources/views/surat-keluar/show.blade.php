@extends('adminlte::page')

@section('title', 'Detail Surat Keluar')

@section('content_header')
    <h1>Detail Surat Keluar</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Nomor Surat</th>
                    <td>{{ $suratKeluar->nomor_surat }}</td>
                </tr>
                <tr>
                    <th>Tujuan</th>
                    <td>{{ $suratKeluar->tujuan }}</td>
                </tr>
                <tr>
                    <th>Perihal</th>
                    <td>{{ $suratKeluar->perihal }}</td>
                </tr>
                <tr>
                    <th>Tanggal Surat</th>
                    <td>{{ $suratKeluar->tanggal_surat }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($suratKeluar->status == 'draft')
                            <span class="badge badge-warning">Draft</span>
                        @else
                            <span class="badge badge-success">Terkirim</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>File</th>
                    <td>
                        @if($suratKeluar->file)
                            <a href="{{ Storage::url($suratKeluar->file) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-file"></i> Lihat File
                            </a>
                        @else
                            <span class="text-muted">Tidak ada file</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>{{ $suratKeluar->keterangan ?? '-' }}</td>
                </tr>
            </table>
            <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('surat-keluar.edit', $suratKeluar->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@stop