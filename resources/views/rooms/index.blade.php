<!DOCTYPE html>
<html>
<head>
    <title>Daftar Ruangan</title>
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
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 2.5em;
        }

        .error { 
            color: #dc3545;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .success {
            color: #28a745;
            background-color: #d4edda;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .add-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 30px;
            transition: background-color 0.3s;
            font-weight: bold;
        }

        .add-button:hover {
            background-color: #45a049;
        }

        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
        }

        .card.tersedia::before {
            background-color: #28a745;
        }

        .card.dipesan::before {
            background-color: #ffc107;
        }

        .card.maintenance::before {
            background-color: #dc3545;
        }

        .card-header {
            padding-bottom: 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .card-title {
            font-size: 1.4em;
            color: #333;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85em;
            font-weight: 500;
            text-transform: capitalize;
        }

        .status-badge.tersedia {
            background-color: #d4edda;
            color: #28a745;
        }

        .status-badge.dipesan {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-badge.maintenance {
            background-color: #f8d7da;
            color: #dc3545;
        }

        .card-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: opacity 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-edit {
            background-color: #2196F3;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 1.1em;
        }

        @media (max-width: 768px) {
            .cards-container {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 10px;
            }

            .card {
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Daftar Ruangan</h1>

            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="error">{{ session('error') }}</div>
            @endif

            <a href="{{ route('rooms.create') }}" class="add-button">+ Tambah Ruangan</a>
        </div>

        @if($rooms->count() > 0)
            <div class="cards-container">
                @foreach($rooms as $room)
                    <div class="card {{ $room->status }}">
                        <div class="card-header">
                            <div class="card-title">{{ $room->name }}</div>
                            <span class="status-badge {{ $room->status }}">
                                {{ $room->status }}
                            </span>
                        </div>
                        <div class="card-actions">
                            <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-edit">Edit</a>
                            <form action="{{ route('rooms.destroy', $room->id) }}" 
                                  method="POST" 
                                  style="display: inline;"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <p>Tidak ada ruangan yang tersedia.</p>
            </div>
        @endif
    </div>
</body>
</html>
