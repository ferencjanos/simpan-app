@extends('adminlte::page')

@section('title', 'Log Aktivitas')

@section('content_header')
    <h1>Log Aktivitas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('activity-log.index') }}">
                <div class="row">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Cari aktivitas..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="log_name" class="form-control">
                            <option value="">-- Semua Log --</option>
                            <option value="default" {{ request('log_name') == 'default' ? 'selected' : '' }}>Default</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <a href="{{ route('activity-log.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th>Data Lama</th>
                        <th>Data Baru</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $index => $activity)
                    <tr>
                        <td>{{ $activities->firstItem() + $index }}</td>
                        <td>{{ $activity->created_at->format('d-m-Y H:i:s') }}</td>
                        <td>
                            @if($activity->causer)
                                <span class="badge badge-primary">{{ $activity->causer->name }}</span>
                            @else
                                <span class="text-muted">System</span>
                            @endif
                        </td>
                        <td>{{ $activity->description }}</td>
                        <td>
                            @if($activity->properties->get('old'))
                                <small>
                                    @foreach($activity->properties->get('old') as $key => $value)
                                        <b>{{ $key }}:</b> {{ $value }}<br>
                                    @endforeach
                                </small>
                            @elseif($activity->properties->count() > 0 && $activity->event == 'created')
                                <span class="text-muted">-</span>
                            @else
                                <small>
                                    @foreach($activity->properties as $key => $value)
                                        @if(!in_array($key, ['old', 'attributes']))
                                            <b>{{ $key }}:</b> {{ $value }}<br>
                                        @endif
                                    @endforeach
                                </small>
                            @endif
                        </td>
                        <td>
                            @if($activity->properties->get('attributes'))
                                <small>
                                    @foreach($activity->properties->get('attributes') as $key => $value)
                                        <b>{{ $key }}:</b> {{ $value }}<br>
                                    @endforeach
                                </small>
                            @elseif($activity->properties->count() > 0)
                                <small>
                                    @foreach($activity->properties as $key => $value)
                                        @if(!in_array($key, ['old', 'attributes']))
                                            <b>{{ $key }}:</b> {{ $value }}<br>
                                        @endif
                                    @endforeach
                                </small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada log aktivitas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $activities->links() }}
        </div>
    </div>
@stop