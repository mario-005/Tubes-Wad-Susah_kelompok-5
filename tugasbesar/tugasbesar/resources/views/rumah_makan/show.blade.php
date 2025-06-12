@extends('layouts.app')

@section('title', $rumahMakan->nama)

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-4">{{ $rumahMakan->nama }}</h1>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($rumahMakan->foto)
                                <img src="{{ Storage::url($rumahMakan->foto) }}" alt="{{ $rumahMakan->nama }}" class="img-fluid rounded">
                            @else
                                <img src="https://via.placeholder.com/400x300?text=No+Image" alt="No Image" class="img-fluid rounded">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h4>Restaurant Information</h4>
                            <p><strong>Address:</strong> {{ $rumahMakan->alamat }}</p>
                            <p><strong>Contact:</strong> {{ $rumahMakan->kontak ?? 'Not available' }}</p>
                            <p><strong>Category:</strong> {{ $rumahMakan->kategori }}</p>
                            <p><strong>Operating Hours:</strong> {{ $rumahMakan->jam_buka }} - {{ $rumahMakan->jam_tutup }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="menu-tab" data-bs-toggle="tab" data-bs-target="#menu" type="button" role="tab">Menu</button>
        </li>
        @if(Auth::user()->role === 'admin')
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="rooms-tab" data-bs-toggle="tab" data-bs-target="#rooms" type="button" role="tab">Rooms</button>
        </li>
        @endif
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="reservations-tab" data-bs-toggle="tab" data-bs-target="#reservations" type="button" role="tab">Reservations</button>
        </li>
        @if(Auth::user()->role === 'admin')
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="operational-tab" data-bs-toggle="tab" data-bs-target="#operational" type="button" role="tab">Operational Status</button>
        </li>
        @endif
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Reviews</button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="myTabContent">
        <!-- Menu Tab -->
        <div class="tab-pane fade show active" id="menu" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Menu</h3>
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('menus.create', ['rumah_makan_id' => $rumahMakan->id]) }}" class="btn btn-primary">Add Menu</a>
                @endif
            </div>
            <div class="row">
                @forelse($rumahMakan->menus as $menu)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            @if($menu->image)
                                <img src="{{ Storage::url($menu->image) }}" class="card-img-top" alt="{{ $menu->name }}">
                            @else
                                <img src="https://via.placeholder.com/400x300?text=No+Image" class="card-img-top" alt="No Image">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $menu->name }}</h5>
                                <p class="card-text">{{ $menu->description }}</p>
                                <p class="card-text"><strong>Price:</strong> Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                <p class="card-text"><small class="text-muted">Status: {{ $menu->status }}</small></p>
                                @if(Auth::user()->role === 'admin')
                                <div class="mt-3">
                                    <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')">Delete</button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">No menu items available yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        @if(Auth::user()->role === 'admin')
        <!-- Rooms Tab -->
        <div class="tab-pane fade" id="rooms" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Rooms</h3>
                <a href="{{ route('rooms.create', ['rumah_makan_id' => $rumahMakan->id]) }}" class="btn btn-primary">Add Room</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Room Name</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rumahMakan->rooms as $room)
                            <tr>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->capacity }} people</td>
                                <td>{{ $room->status }}</td>
                                <td>
                                    <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No rooms available yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Reservations Tab -->
        <div class="tab-pane fade" id="reservations" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Reservations</h3>
                <a href="{{ route('reservations.create', ['rumah_makan_id' => $rumahMakan->id]) }}" class="btn btn-primary">Make Reservation</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Room</th>
                            <th>Guest Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            @if(Auth::user()->role === 'admin')
                            <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rumahMakan->reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->room->name }}</td>
                                <td>{{ $reservation->guest_name }}</td>
                                <td>{{ $reservation->reservation_date }}</td>
                                <td>{{ $reservation->start_time }} - {{ $reservation->end_time }}</td>
                                <td>{{ $reservation->status }}</td>
                                @if(Auth::user()->role === 'admin')
                                <td>
                                    <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')">Delete</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role === 'admin' ? '6' : '5' }}" class="text-center">No reservations yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(Auth::user()->role === 'admin')
        <!-- Operational Status Tab -->
        <div class="tab-pane fade" id="operational" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Operational Status</h3>
                <a href="{{ route('operational-statuses.create', ['rumah_makan_id' => $rumahMakan->id]) }}" class="btn btn-primary">Update Status</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Opening Time</th>
                            <th>Closing Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rumahMakan->operationalStatuses as $status)
                            <tr>
                                <td>{{ $status->hari }}</td>
                                <td>{{ $status->jam_buka }}</td>
                                <td>{{ $status->jam_tutup }}</td>
                                <td>{{ $status->status }}</td>
                                <td>
                                    <a href="{{ route('operational-statuses.edit', $status->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('operational-statuses.destroy', $status->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No operational status available yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Reviews Tab -->
        <div class="tab-pane fade" id="reviews" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Reviews</h3>
                <a href="{{ route('ulasan.create', ['rumah_makan_id' => $rumahMakan->id]) }}" class="btn btn-primary">Add Review</a>
            </div>
            <div class="row">
                @forelse($rumahMakan->ulasans as $ulasan)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">{{ $ulasan->nama_pengulas }}</h5>
                                    <div class="text-warning">
                                        @for($i = 0; $i < $ulasan->rating; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="card-text">{{ $ulasan->komentar }}</p>
                                <p class="card-text"><small class="text-muted">Posted on {{ $ulasan->created_at->format('M d, Y') }}</small></p>
                                @if(Auth::user()->role === 'admin')
                                <div class="mt-3">
                                    <form action="{{ route('ulasan.destroy', $ulasan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">No reviews yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

@include('layouts.footer')
@endsection

<style>
    .nav-tabs .nav-link {
        color: #6c757d;
    }
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        font-weight: 500;
    }
    .tab-content {
        padding: 20px 0;
    }
    .card {
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .table-responsive {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
</style>
