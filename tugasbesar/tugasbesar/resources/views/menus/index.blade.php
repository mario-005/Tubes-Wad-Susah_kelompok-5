@extends('layouts.app')

@section('title', 'Dashboard - Telkom Foodies')

@section('content')
<div class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">Stop looking for a restaurant - find it.</h1>
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" placeholder="Search for Restaurants by Name, Cuisine, Location">
        </div>
    </div>
</div>

<div class="container">
    @if(auth()->user()->role === 'admin')
    <div class="header-actions">
        <a href="{{ route('rumah-makan.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Tambah Restoran
        </a>
    </div>
    @endif

    <div class="restaurant-grid">
        @foreach($rumahMakans ?? [] as $rm)
        <div class="restaurant-card">
            <a href="{{ route('rumah-makan.show', $rm->id) }}" class="restaurant-link">
                <img src="{{ $rm->foto ? Storage::url($rm->foto) : 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4' }}" 
                     alt="{{ $rm->nama }}" 
                     class="restaurant-image">
                <div class="restaurant-info">
                    <h3 class="restaurant-name">{{ $rm->nama }}</h3>
                    <div class="restaurant-meta">
                        <span class="cuisine">{{ $rm->kategori }}</span>
                        <span class="separator">|</span>
                        <span class="location">{{ $rm->alamat }}</span>
                    </div>
                    <div class="restaurant-hours">
                        {{ $rm->jam_buka ? \Carbon\Carbon::parse($rm->jam_buka)->format('H:i') : '09:00' }} PM - 
                        {{ $rm->jam_tutup ? \Carbon\Carbon::parse($rm->jam_tutup)->format('H:i') : '21:00' }} AM
                    </div>
                    <div class="rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= ($rm->rating ?? 4))
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                        <span class="review-count">({{ $rm->ulasan_count ?? rand(50, 200) }} reviews)</span>
                    </div>
                </div>
            </a>
            @if(auth()->user()->role === 'admin')
            <div class="admin-actions">
                <a href="{{ route('rumah-makan.edit', $rm->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('rumah-makan.destroy', $rm->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>

<style>
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                    url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4');
        background-size: cover;
        background-position: center;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: -80px;
        padding-top: 80px;
    }

    .hero-content {
        text-align: center;
        max-width: 800px;
        padding: 0 20px;
    }

    .hero-title {
        color: white;
        font-size: 2.5rem;
        margin-bottom: 2rem;
        font-weight: 600;
    }

    .search-container {
        position: relative;
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
    }

    .search-input {
        width: 100%;
        padding: 15px 20px 15px 50px;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }

    .restaurant-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        padding: 40px 0;
    }

    .restaurant-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .restaurant-card:hover {
        transform: translateY(-5px);
    }

    .restaurant-link {
        text-decoration: none;
        color: inherit;
    }

    .restaurant-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .restaurant-info {
        padding: 20px;
    }

    .restaurant-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .restaurant-meta {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 8px;
    }

    .separator {
        margin: 0 8px;
        color: #ddd;
    }

    .restaurant-hours {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .rating {
        color: #ffc107;
        font-size: 0.9rem;
    }

    .review-count {
        color: #666;
        margin-left: 5px;
    }

    .admin-actions {
        padding: 15px 20px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn {
        padding: 8px 12px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #000;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn:hover {
        transform: translateY(-2px);
    }
</style>
@endsection
