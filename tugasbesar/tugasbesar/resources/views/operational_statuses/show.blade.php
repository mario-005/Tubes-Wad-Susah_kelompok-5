@extends('layouts.app')

@section('content')
<h3>Detail Jadwal Operasional</h3>

<ul class="list-group mb-3">
    <li class="list-group-item"><strong>Tanggal:</strong> {{ $status->date }}</li>
    <li class="list-group-item"><strong>Jam Buka:</strong> {{ $status->open_time }}</li>
    <li class="list-group-item"><strong>Jam Tutup:</strong> {{ $status->close_time }}</li>
    <li class="list-group-item"><strong>Status:</strong> {{ $status->status }}</li>
</ul>

<a href="{{ route('menus.index') }}" class="btn btn-secondary">Kembali</a>
<a href="{{ route('operational-statuses.edit', $status->id) }}" class="btn btn-warning">Edit</a>
@endsection
