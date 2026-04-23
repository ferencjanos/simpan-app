@extends('adminlte::page')

@section('title', 'Edit Surat Keluar')

@section('content_header')
    <h1>Edit Surat Keluar</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('surat-keluar.update', $suratKeluar->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nomor Surat</label>
                    <input type="text" name="nomor_surat" class="form-control @error('nomor_surat') is-invalid @enderror" value="{{ old('nomor_surat', $suratKeluar->nomor_surat) }}">
                    @error('nomor_surat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Tujuan</label>
                    <input type="text" name="tujuan" class="form-control @error('tujuan') is-invalid @enderror" value="{{ old('tujuan', $suratKeluar->tujuan) }}">
                    @error('tujuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Perihal</label>
                    <input type="text" name="perihal" class="form-control @error('perihal') is-invalid @enderror" value="{{ old('perihal', $suratKeluar->perihal) }}">
                    @error('perihal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" class="form-control @error('tanggal_surat') is-invalid @enderror" value="{{ old('tanggal_surat', $suratKeluar->tanggal_surat) }}">
                    @error('tanggal_surat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="draft" {{ $suratKeluar->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="terkirim" {{ $suratKeluar->status == 'terkirim' ? 'selected' : '' }}>Terkirim</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Upload File Baru (PDF/DOC) — kosongkan jika tidak ingin mengganti</label>
                    <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
                    @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if($suratKeluar->file)
                        <small class="text-muted">File saat ini: <a href="{{ Storage::url($suratKeluar->file) }}" target="_blank">Lihat File</a></small>
                    @endif
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori_id" class="form-control">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $suratKeluar->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->kode }} - {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $suratKeluar->keterangan) }}</textarea>
                </div>
                <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@stop