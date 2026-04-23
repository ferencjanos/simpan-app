@extends('adminlte::page')

@section('title', 'Tambah Surat Keluar')

@section('content_header')
    <h1>Tambah Surat Keluar</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('surat-keluar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Nomor Surat</label>
                    <input type="text" name="nomor_surat" class="form-control @error('nomor_surat') is-invalid @enderror" value="{{ old('nomor_surat') }}">
                    @error('nomor_surat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <!-- resources/views/surat-keluar/create.blade.php -->
                <div class="form-group">
                    <label for="tujuan">Tujuan <span class="text-danger">*</span></label>
                    <input type="text" 
                        name="tujuan" 
                        id="tujuan" 
                        class="form-control @error('tujuan') is-invalid @enderror"
                        value="{{ old('tujuan') }}"
                        placeholder="Masukkan tujuan surat"
                        required>
                    @error('tujuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Perihal</label>
                    <input type="text" name="perihal" class="form-control @error('perihal') is-invalid @enderror" value="{{ old('perihal') }}">
                    @error('perihal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Tanggal Surat</label>
                    <input type="date" name="tanggal_surat" class="form-control @error('tanggal_surat') is-invalid @enderror" value="{{ old('tanggal_surat') }}">
                    @error('tanggal_surat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="draft">Draft</option>
                        <option value="terkirim">Terkirim</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Upload File (PDF/DOC)</label>
                    <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
                    @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori_id" class="form-control">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->kode }} - {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                </div>
                <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@stop