@extends('layouts.app')

@section('content')
<h3>Tambah Jadwal Operasional</h3>

<form action="{{ route('operational-statuses.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="date" class="form-label">Tanggal</label>
        <input type="date" name="date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="open_time" class="form-label">Jam Buka</label>
        <input type="time" name="open_time" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="close_time" class="form-label">Jam Tutup</label>
        <input type="time" name="close_time" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="open">Buka</option>
            <option value="closed">Tutup</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('menus.index') }}" class="btn btn-secondary">Kembali</a>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[type="time"]').forEach(function(input) {
        input.addEventListener('change', function() {
            this.blur();
        });
    });
});
</script>
@endsection
