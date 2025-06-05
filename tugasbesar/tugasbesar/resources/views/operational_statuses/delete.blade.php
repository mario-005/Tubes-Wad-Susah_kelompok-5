@extends('layouts.app')


@section('content')
<h1>Edit Jadwal</h1>

<form action="{{ route('operational-statuses.update', $status->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Tanggal: <input type="date" name="date" value="{{ $status->date }}"></label><br>
    <label>Jam Buka: <input type="time" name="open_time" value="{{ $status->open_time }}"></label><br>
    <label>Jam Tutup: <input type="time" name="close_time" value="{{ $status->close_time }}"></label><br>
    <label>Status:
        <select name="status">
            <option value="open" {{ $status->status == 'open' ? 'selected' : '' }}>Buka</option>
            <option value="closed" {{ $status->status == 'closed' ? 'selected' : '' }}>Tutup</option>
        </select>
    </label><br>
    <button type="submit">Update</button>
</form>
@endsection
