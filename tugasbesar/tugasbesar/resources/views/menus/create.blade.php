<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Menu - {{ $rumahMakan->nama }}</title>
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
            padding: 30px;
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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
            font-size: 24px;
            color: #1f2937;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
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

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: 500;
            font-size: 14px;
            color: #374151;
            display: block;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #e42313;
            box-shadow: 0 0 0 3px rgba(228, 35, 19, 0.1);
            outline: none;
        }

        textarea.form-control {
            height: 100px;
            resize: vertical;
        }

        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
        }

        .btn-submit,
        .btn-back {
            padding: 10px 24px;
            font-size: 14px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('dashboard') }}" class="logo">Telkom Foodies</a>
            <a href="{{ route('rumah-makan.show', $rumahMakan->id) }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <h1>Tambah Menu Baru</h1>

        <div class="restaurant-info">
            <h3>{{ $rumahMakan->nama }}</h3>
            <p>{{ $rumahMakan->alamat }}</p>
        </div>

        <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="rumah_makan_id" value="{{ $rumahMakan->id }}">

            <div class="form-group">
                <label for="name">Nama Menu</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="price">Harga</label>
                <input type="number" name="price" id="price" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="image">Foto Menu</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="available">Tersedia</option>
                    <option value="out_of_stock">Habis</option>
                </select>
            </div>

            <div class="button-group">
                <a href="{{ route('rumah-makan.show', $rumahMakan->id) }}" class="btn-back">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Simpan Menu
                </button>
            </div>
        </form>
    </div>
</body>
</html>
