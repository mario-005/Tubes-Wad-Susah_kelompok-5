@extends('layouts.app')

@section('content')
<h3>Edit Jadwal Operasional</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('operational-statuses.update', $status->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="date" class="form-label">Tanggal</label>
        <input type="date" name="date" class="form-control" value="{{ old('date', $status->date) }}" required>
    </div>

    <div class="mb-3">
        <label for="open_time" class="form-label">Jam Buka</label>
        <input type="time" name="open_time" class="form-control"
               value="{{ old('open_time') ?? ($status->open_time ? \Carbon\Carbon::createFromFormat('H:i:s', $status->open_time)->format('H:i') : '') }}">
    </div>

    <div class="mb-3">
        <label for="close_time" class="form-label">Jam Tutup</label>
        <input type="time" name="close_time" class="form-control"
               value="{{ old('close_time') ?? ($status->close_time ? \Carbon\Carbon::createFromFormat('H:i:s', $status->close_time)->format('H:i') : '') }}">
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="open" {{ old('status', $status->status) == 'open' ? 'selected' : '' }}>Buka</option>
            <option value="closed" {{ old('status', $status->status) == 'closed' ? 'selected' : '' }}>Tutup</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Perbarui & Kembali</button>
    <a href="{{ route('operational-statuses.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
