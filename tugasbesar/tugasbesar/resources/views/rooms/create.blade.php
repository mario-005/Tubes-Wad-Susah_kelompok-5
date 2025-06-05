<!DOCTYPE html>
<html>
<head>
    <title>Tambah Ruangan Baru</title>
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

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e1e1;
            border-radius: 5px;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
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

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        select option {
            padding: 12px;
        }

        select option[value="tersedia"] {
            color: #28a745;
        }

        select option[value="dipesan"] {
            color: #ffc107;
        }

        select option[value="maintenance"] {
            color: #dc3545;
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
                <h1>Tambah Ruangan Baru</h1>
                <p class="subtitle">Isi formulir di bawah untuk menambahkan ruangan baru</p>
            </div>

            @if(session('error'))
                <div class="error">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('rooms.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label>Nama Ruangan</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="Masukkan nama ruangan"
                           required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Kapasitas Ruangan</label>
                    <input type="number" 
                           name="capacity" 
                           value="{{ old('capacity') }}" 
                           placeholder="Masukkan kapasitas ruangan (orang)"
                           min="1"
                           required>
                    @error('capacity')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Status Ruangan</label>
                    <select name="status" required>
                        <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>
                            Tersedia
                        </option>
                        <option value="dipesan" {{ old('status') == 'dipesan' ? 'selected' : '' }}>
                            Dipesan
                        </option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                            Maintenance
                        </option>
                    </select>
                    @error('status')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Tambah Ruangan</button>
                    <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
