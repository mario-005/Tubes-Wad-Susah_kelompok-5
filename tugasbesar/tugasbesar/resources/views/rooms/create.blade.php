<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Ruangan - {{ $rumahMakan->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 2rem 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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
            background: #e42313;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo {
            color: #e42313;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            margin-bottom: 1rem;
            display: block;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            text-decoration: none;
            margin-bottom: 1rem;
        }

        .back-link:hover {
            color: #374151;
        }

        h1 {
            color: #1f2937;
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .subtitle {
            color: #6b7280;
            font-size: 1rem;
            margin-bottom: 30px;
        }

        .restaurant-info {
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: 1px solid #e5e7eb;
        }

        .restaurant-info h3 {
            margin: 0;
            color: #1f2937;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .restaurant-info p {
            margin: 5px 0 0;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .error { 
            color: #dc2626;
            background-color: #fee2e2;
            padding: 10px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .success {
            color: #059669;
            background-color: #d1fae5;
            padding: 10px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 500;
            font-size: 14px;
        }

        input, select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #e42313;
            box-shadow: 0 0 0 3px rgba(228, 35, 19, 0.1);
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            padding: 10px 24px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-submit {
            background-color: #e42313;
            color: white;
        }

        .btn-submit:hover {
            background-color: #b91c1c;
            color: white;
        }

        .btn-back {
            background-color: #f3f4f6;
            color: #374151;
        }

        .btn-back:hover {
            background-color: #e5e7eb;
            color: #1f2937;
        }

        select option {
            padding: 12px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .card {
                padding: 20px;
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
                <a href="{{ route('dashboard') }}" class="logo">Telkom Foodies</a>
                <a href="{{ route('rumah-makan.show', $rumahMakan->id) }}" class="back-link">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <h1>Tambah Ruangan Baru</h1>
            <p class="subtitle">Isi formulir di bawah untuk menambahkan ruangan baru</p>

            <div class="restaurant-info">
                <h3>{{ $rumahMakan->nama }}</h3>
                <p>{{ $rumahMakan->alamat }}</p>
            </div>

            @if($errors->any())
                <div class="error">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('rooms.store') }}" method="POST">
                @csrf
                <input type="hidden" name="rumah_makan_id" value="{{ $rumahMakan->id }}">

                <div class="form-group">
                    <label for="name">Nama Ruangan</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="capacity">Kapasitas</label>
                    <input type="number" id="capacity" name="capacity" value="{{ old('capacity') }}" required>
                    @error('capacity')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="dipesan">Dipesan</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                    @error('status')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="button-group">
                    <a href="{{ route('rumah-makan.show', $rumahMakan->id) }}" class="btn btn-back">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-save"></i> Simpan Ruangan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
