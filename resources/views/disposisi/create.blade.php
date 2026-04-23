@extends('adminlte::page')

@section('title', 'Buat Disposisi')

@section('content_header')
    <h1>Buat Disposisi</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('disposisi.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Surat Masuk</label>
                    <select name="surat_masuk_id" class="form-control @error('surat_masuk_id') is-invalid @enderror">
                        <option value="">-- Pilih Surat Masuk --</option>
                        @foreach($suratMasuks as $surat)
                            <option value="{{ $surat->id }}" {{ isset($selectedSurat) && $selectedSurat->id == $surat->id ? 'selected' : '' }}>
                                {{ $surat->nomor_surat }} - {{ $surat->perihal }}
                            </option>
                        @endforeach
                    </select>
                    @error('surat_masuk_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Kepada</label>
                    <select name="kepada_user_id" class="form-control @error('kepada_user_id') is-invalid @enderror">
                        <option value="">-- Pilih Penerima --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }} ({{ $user->roles->first()->name ?? 'no role' }})
                            </option>
                        @endforeach
                    </select>
                    @error('kepada_user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Instruksi</label>
                    <textarea name="instruksi" class="form-control @error('instruksi') is-invalid @enderror" rows="3" placeholder="Tuliskan instruksi disposisi...">{{ old('instruksi') }}</textarea>
                    @error('instruksi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Batas Waktu</label>
                    <input type="date" name="batas_waktu" class="form-control @error('batas_waktu') is-invalid @enderror" value="{{ old('batas_waktu') }}">
                    @error('batas_waktu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="catatan" class="form-control" rows="2" placeholder="Catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                </div>
                <a href="{{ route('disposisi.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Kirim Disposisi</button>
            </form>
        </div>
    </div>
@stop