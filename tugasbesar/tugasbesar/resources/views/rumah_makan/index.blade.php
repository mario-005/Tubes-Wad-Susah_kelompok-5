<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Rumah Makan</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e293b;
            text-align: center;
            margin-top: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px 60px;
        }

        /* Header Section */
        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 40px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin: 0;
            color: #1e293b;
        }

        .header p {
            font-size: 1.2rem;
            margin-top: 10px;
            color: #4b5563;
        }

        .btn-add {
            background-color: #10b981;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .btn-add:hover {
            background-color: #059669;
        }

        /* Grid Section */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
            margin-top: 30px;
        }

        /* Card Styles */
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

        /* Button Actions */
        .actions {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            padding: 16px 20px;
            border-top: 1px solid #e2e8f0;
            background-color: #f9fafb;
        }

        .btn,
        .actions form button {
            flex: 1;
            padding: 12px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
            text-align: center;
            min-width: 80px;
            display: inline-block;
        }

        .btn-info { background-color: #3b82f6; }
        .btn-warning { background-color: #f59e0b; }
        .btn-danger { background-color: #ef4444; }

        .btn-info:hover { background-color: #2563eb; }
        .btn-warning:hover { background-color: #d97706; }
        .btn-danger:hover { background-color: #dc2626; }

        /* Footer Section */
        footer {
            background-color: #333;
            color: #fff;
            padding: 40px 0;
            margin-top: 40px;
            text-align: center;
        }

        footer .footer-content p {
            margin: 0;
            font-size: 1rem;
            color: #e2e8f0;
        }

        footer input {
            padding: 12px;
            margin-top: 10px;
            width: 200px;
            border-radius: 8px;
            border: none;
        }

        footer .social-icons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        footer .social-icons a {
            color: #fff;
            font-size: 1.5rem;
            text-decoration: none;
            transition: color 0.3s;
        }

        footer .social-icons a:hover {
            color: #10b981;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Daftar Rumah Makan</h1>
            <p>Food is an important part of a balanced diet</p>
            <a href="{{ route('rumah-makan.create') }}" class="btn-add">+ Tambah Rumah Makan</a>
        </div>

        <div class="grid">
            @foreach ($rumahMakans as $rm)
                <div class="card">
                    <div class="card-header" style="background-image: url('https://source.unsplash.com/400x300/?restaurant');"></div>
                    <div class="card-body">
                        <div class="title">{{ $rm->nama }}</div>
                        <div class="subtitle">{{ $rm->kategori }} | {{ $rm->alamat }}</div>
                        <div class="time">{{ date('h.i A', strtotime($rm->jam_buka)) }} - {{ date('h.i A', strtotime($rm->jam_tutup)) }}</div>
                        <div class="rating">
                            <span class="stars">★ ★ ★ ☆ ☆</span>
                            ({{ rand(100, 5000) }} reviews)
                        </div>
                    </div>
                    <div class="actions">
                        <a href="{{ route('rumah-makan.show', $rm->id) }}" class="btn btn-info">Detail</a>
                        <a href="{{ route('rumah-makan.edit', $rm->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('rumah-makan.destroy', $rm->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
