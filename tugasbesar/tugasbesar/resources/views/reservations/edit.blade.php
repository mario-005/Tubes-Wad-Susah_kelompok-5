<!DOCTYPE html>
<html>
<head>
    <title>Edit Reservasi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: #4CAF50;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            color: #333;
            font-size: 2em;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            font-size: 1.1em;
            margin-bottom: 30px;
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group.half {
            flex: 1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e1e1;
            border-radius: 5px;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .error-message {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            font-size: 1em;
            transition: all 0.3s ease;
            flex: 1;
            text-align: center;
            text-decoration: none;
        }

        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .card {
                padding: 20px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>Edit Reservasi</h1>
                <p class="subtitle">Ubah detail reservasi Anda</p>
            </div>

            @if(session('error'))
                <div class="error">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Nama Pemesan</label>
                    <input type="text" 
                           name="guest_name" 
                           value="{{ old('guest_name', $reservation->guest_name) }}" 
                           placeholder="Masukkan nama Anda"
                           required>
                    @error('guest_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Ruangan</label>
                    <select name="room_id" required>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" 
                                    {{ old('room_id', $reservation->room_id) == $room->id ? 'selected' : '' }}
                                    {{ $room->status !== 'tersedia' && $room->id !== $reservation->room_id ? 'disabled' : '' }}>
                                {{ $room->name }} 
                                @if($room->status !== 'tersedia' && $room->id !== $reservation->room_id)
                                    ({{ ucfirst($room->status) }})
                                @else
                                    (Kapasitas: {{ $room->capacity }} orang)
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Tanggal Reservasi</label>
                    <input type="date" 
                           name="reservation_date" 
                           value="{{ old('reservation_date', $reservation->reservation_date->format('Y-m-d')) }}" 
                           min="{{ date('Y-m-d') }}"
                           required>
                    @error('reservation_date')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label>Waktu Mulai</label>
                        <input type="time" 
                               name="start_time" 
                               value="{{ old('start_time', $reservation->start_time->format('H:i')) }}" 
                               required>
                        @error('start_time')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label>Waktu Selesai</label>
                        <input type="time" 
                               name="end_time" 
                               value="{{ old('end_time', $reservation->end_time->format('H:i')) }}" 
                               required>
                        @error('end_time')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Keperluan</label>
                    <textarea name="purpose" 
                              placeholder="Jelaskan keperluan penggunaan ruangan"
                              required>{{ old('purpose', $reservation->purpose) }}</textarea>
                    @error('purpose')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>

            <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="margin-top: 20px;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="width: 100%;" 
                        onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                    Batalkan Reservasi
                </button>
            </form>
        </div>
    </div>
</body>
</html>
