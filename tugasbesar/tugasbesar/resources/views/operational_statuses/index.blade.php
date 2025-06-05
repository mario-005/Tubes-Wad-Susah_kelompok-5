@extends('layouts.app')

@section('content')
<h2>Status Operasional</h2>
<a href="{{ route('operational-statuses.create') }}" class="btn btn-primary mb-3">+ Tambah Jadwal</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tanggal</th><th>Jam Buka</th><th>Jam Tutup</th><th>Status</th><th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($statuses as $status)
        <tr>
            <td>{{ $status->date }}</td>
            <td>{{ $status->open_time }}</td>
            <td>{{ $status->close_time }}</td>
            <td>{{ $status->status }}</td>
            <td>
                <a href="{{ route('operational-statuses.edit', $status->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('operational-statuses.destroy', $status->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
