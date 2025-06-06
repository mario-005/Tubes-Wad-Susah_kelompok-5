<!-- @extends('layouts.app') -->

@section('title', 'Daftar Rumah Makan')

@section('content')
<div class="container">
    <div class="header">
        <h1>Daftar Rumah Makan</h1>
        <p>Temukan rumah makan terbaik di sekitar kampus</p>
        @if(Auth::user() && Auth::user()->role === 'admin')
            <a href="{{ route('rumah-makan.create') }}" class="btn btn-primary">Tambah Rumah Makan</a>
        @endif
    </div>

    <div class="grid">
        @foreach($rumahMakans as $rumahMakan)
        <div class="card">
            <div class="card-header" style="background-image: url('{{ Storage::url($rumahMakan->foto) }}')"></div>
            <div class="card-body">
                <h2 class="title">{{ $rumahMakan->nama }}</h2>
                <p class="subtitle">{{ $rumahMakan->alamat }}</p>
                <p class="time">{{ $rumahMakan->jam_buka }} - {{ $rumahMakan->jam_tutup }}</p>
                <div class="rating">
                    <span class="stars">★</span>
                    <span>{{ number_format($rumahMakan->rating_avg, 1) }} ({{ $rumahMakan->ulasan_count }} ulasan)</span>
                </div>
            </div>
            <div class="actions">
                <a href="{{ route('rumah-makan.show', $rumahMakan->id) }}" class="btn btn-primary">Detail</a>
                @if(Auth::user() && Auth::user()->role === 'admin')
                    <a href="{{ route('rumah-makan.edit', $rumahMakan->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('rumah-makan.destroy', $rumahMakan->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin ingin menghapus rumah makan ini?')">Hapus</button>
                    </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
    margin-top: 30px;
}

.card {
    background-color: #ffffff;
    border-radius: 16px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-6px);
}

.card-header {
    height: 250px;
    background-size: cover;
    background-position: center;
}

.card-body {
    padding: 20px;
    flex-grow: 1;
}

.title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
}

.subtitle {
    color: #64748b;
    font-size: 1rem;
    margin-bottom: 12px;
}

.time {
    margin-top: 12px;
    font-weight: bold;
    color: #1e293b;
}

.rating {
    margin-top: 10px;
    font-size: 1rem;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 4px;
}

.stars {
    color: #facc15;
    font-size: 1.2rem;
}

.actions {
    display: flex;
    justify-content: space-between;
    gap: 8px;
    padding: 16px 20px;
    border-top: 1px solid #e2e8f0;
    background-color: #f9fafb;
}
</style>
@endsection
