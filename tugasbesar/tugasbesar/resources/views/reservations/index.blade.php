<!DOCTYPE html>
<html>
<head>
    <title>Reservasi Ruangan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            color: #333;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 1.1em;
        }

        .action-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .action-button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }

        .reservations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .reservation-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .reservation-card:hover {
            transform: translateY(-5px);
        }

        .reservation-header {
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .reservation-title {
            font-size: 1.2em;
            color: #333;
            margin-bottom: 5px;
        }

        .reservation-date {
            color: #666;
            font-size: 0.9em;
        }

        .reservation-details {
            margin-top: 15px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-label {
            color: #666;
            font-weight: 500;
        }

        .detail-value {
            color: #333;
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.85em;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .empty-state h2 {
            color: #666;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #999;
            margin-bottom: 20px;
        }

        /* Available Rooms Section Styles */
        .section-title {
            font-size: 1.8em;
            color: #333;
            margin: 40px 0 20px;
            text-align: center;
        }

        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .room-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .room-card:hover {
            transform: translateY(-5px);
        }

        .room-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }

        .room-card.available::before {
            background: #28a745;
        }

        .room-card.booked::before {
            background: #ffc107;
        }

        .room-card.maintenance::before {
            background: #dc3545;
        }

        .room-name {
            font-size: 1.4em;
            color: #333;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .room-capacity {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: #666;
        }

        .room-capacity i {
            margin-right: 8px;
        }

        .room-status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.9em;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .status-available {
            background-color: #d4edda;
            color: #155724;
        }

        .status-booked {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-maintenance {
            background-color: #f8d7da;
            color: #721c24;
        }

        .reserve-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .reserve-button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }

        .reserve-button.disabled {
            background-color: #6c757d;
            cursor: not-allowed;
            pointer-events: none;
        }

        .card-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            border-top: 1px solid #f0f0f0;
            padding-top: 15px;
        }

        .btn-edit {
            width: 100%;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
            background-color: #ffc107;
            color: #000;
        }

        .btn-edit:hover {
            background-color: #e0a800;
            transform: translateY(-2px);
        }

        .btn-disabled {
            background-color: #6c757d;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            position: relative;
        }

        .modal-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .modal-title {
            font-size: 1.5em;
            color: #333;
            margin: 0;
        }

        .close-modal {
            position: absolute;
            right: 25px;
            top: 25px;
            font-size: 1.5em;
            cursor: pointer;
            color: #666;
            transition: color 0.3s;
        }

        .close-modal:hover {
            color: #333;
        }

        .modal-body {
            margin-bottom: 20px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .header h1 {
                font-size: 2em;
            }

            .reservations-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reservasi Ruangan</h1>
            <p>Pesan ruangan sesuai kebutuhan Anda</p>
        </div>

        <h2 class="section-title">Ruangan yang Tersedia</h2>
        <div class="rooms-grid">
            @foreach($rooms as $room)
                <div class="room-card {{ $room->status }}">
                    <h3 class="room-name">{{ $room->name }}</h3>
                    <div class="room-capacity">
                        <i class="fas fa-users"></i>
                        Kapasitas: {{ $room->capacity }} orang
                    </div>
                    <div class="room-status status-{{ $room->status }}">
                        {{ ucfirst($room->status) }}
                    </div>
                    @if($room->status === 'tersedia')
                        <a href="{{ route('reservations.create', ['room_id' => $room->id]) }}" 
                           class="reserve-button">
                            Reservasi Sekarang
                        </a>
                    @else
                        <button class="reserve-button disabled">
                            {{ $room->status === 'dipesan' ? 'Sudah Dipesan' : 'Dalam Perbaikan' }}
                        </button>
                    @endif
                </div>
            @endforeach
        </div>

        <h2 class="section-title">Reservasi Anda</h2>
        <a href="{{ route('reservations.create') }}" class="action-button">
            Buat Reservasi Baru
        </a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($reservations->isEmpty())
            <div class="empty-state">
                <h2>Belum Ada Reservasi</h2>
                <p>Anda belum memiliki reservasi ruangan. Mulai pesan ruangan sekarang!</p>
                <a href="{{ route('reservations.create') }}" class="action-button">
                    Buat Reservasi
                </a>
            </div>
        @else
            <div class="reservations-grid">
                @foreach($reservations as $reservation)
                    <div class="reservation-card">
                        <div class="reservation-header">
                            <h3 class="reservation-title">Ruangan {{ $reservation->room->name }}</h3>
                            <div class="reservation-date">
                                {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d F Y') }}
                            </div>
                        </div>
                        <div class="reservation-details">
                            <div class="detail-item">
                                <span class="detail-label">Nama Pemesan</span>
                                <span class="detail-value">{{ $reservation->guest_name }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Waktu</span>
                                <span class="detail-value">
                                    {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}
                                </span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Keperluan</span>
                                <span class="detail-value">{{ $reservation->purpose }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Status</span>
                                <span class="status-badge status-{{ strtolower($reservation->status) }}">
                                    {{ $reservation->status }}
                                </span>
                            </div>
                        </div>
                        <div class="card-actions">
                            <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn-edit">
                                Ubah Reservasi
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>

@include('layouts.footer')
