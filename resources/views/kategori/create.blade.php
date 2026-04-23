@extends('adminlte::page')

@section('title', 'Tambah Kategori')

@section('content_header')
    <h1>Tambah Kategori</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Kode Kategori</label>
                    <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode') }}" placeholder="Contoh: SK, UND, LAP">
                    @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Contoh: Surat Keputusan">
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                </div>
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@stop