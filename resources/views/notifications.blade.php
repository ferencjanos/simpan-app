@extends('adminlte::page')

@section('title', 'Notifikasi')

@section('content_header')
    <h1>Notifikasi</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Notifikasi</h3>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <a href="{{ route('notifications.readall') }}" class="btn btn-sm btn-info float-right">
                    <i class="fas fa-check-double"></i> Tandai Semua Dibaca
                </a>
            @endif
        </div>
        <div class="card-body p-0">
            <ul class="list-group">
                @forelse(auth()->user()->notifications as $notification)
                <li class="list-group-item {{ $notification->read_at ? '' : 'bg-light' }}">
                    <div class="d-flex justify-content-between">
                        <div>
                            <i class="fas fa-share-square text-primary mr-2"></i>
                            <strong>{{ $notification->data['message'] }}</strong>
                            <br>
                            <small>Surat: {{ $notification->data['surat_masuk'] }} - {{ $notification->data['perihal'] }}</small>
                            <br>
                            <small>Instruksi: {{ $notification->data['instruksi'] }}</small>
                        </div>
                        <div class="text-right">
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            <br>
                            @if(!$notification->read_at)
                                <a href="{{ route('notifications.read', $notification->id) }}" class="btn btn-xs btn-success mt-1">
                                    Tandai Dibaca
                                </a>
                            @else
                                <span class="badge badge-secondary">Dibaca</span>
                            @endif
                        </div>
                    </div>
                </li>
                @empty
                <li class="list-group-item text-center">Tidak ada notifikasi.</li>
                @endforelse
            </ul>
        </div>
    </div>
@section('js')
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>
@endsection
@stop