@extends('adminlte::page')

@section('title', 'Detail Disposisi')

@section('content_header')
    <h1>Detail Disposisi</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Disposisi</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Nomor Surat</th>
                            <td>{{ $disposisi->suratMasuk->nomor_surat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Perihal</th>
                            <td>{{ $disposisi->suratMasuk->perihal ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Dari</th>
                            <td>{{ $disposisi->dariUser->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kepada</th>
                            <td>{{ $disposisi->kepadaUser->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Instruksi</th>
                            <td>{{ $disposisi->instruksi }}</td>
                        </tr>
                        <tr>
                            <th>Batas Waktu</th>
                            <td>{{ $disposisi->batas_waktu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($disposisi->status == 'belum dibaca')
                                    <span class="badge badge-danger">Belum Dibaca</span>
                                @elseif($disposisi->status == 'sudah dibaca')
                                    <span class="badge badge-warning">Sudah Dibaca</span>
                                @else
                                    <span class="badge badge-success">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $disposisi->catatan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Update Status --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Status</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('disposisi.update', $disposisi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="belum dibaca" {{ $disposisi->status == 'belum dibaca' ? 'selected' : '' }}>Belum Dibaca</option>
                                <option value="sudah dibaca" {{ $disposisi->status == 'sudah dibaca' ? 'selected' : '' }}>Sudah Dibaca</option>
                                <option value="selesai" {{ $disposisi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea name="catatan" class="form-control" rows="3">{{ $disposisi->catatan }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Update Status</button>
                    </form>
                </div>
            </div>
            <a href="{{ route('disposisi.index') }}" class="btn btn-secondary btn-block mt-2">Kembali</a>
        </div>
    </div>
@stop