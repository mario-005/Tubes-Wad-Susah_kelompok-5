<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Restaurant - Telkom Foodies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fff;
            padding-top: 2rem;
        }

        .container {
            max-width: 800px;
            margin: 10px auto;
            background-color: #f9fbff;
            padding: 40px;
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

        h2 {
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 6px;
        }

        p.description {
            text-align: center;
            font-size: 14px;
            color: #475569;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-weight: 500;
            font-size: 14px;
            margin-bottom: 6px;
            color: #0f172a;
        }

        input[type="text"],
        input[type="file"],
        input[type="time"] {
            width: 100%;
            padding: 10px 14px;
            font-size: 14px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background-color: #fff;
        }

        .form-group input::placeholder {
            color: #cbd5e1;
        }

        .time-inputs {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .time-inputs input[type="time"] {
            flex: 1;
        }

        .upload-box {
            border: 2px dashed #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            background-color: #fff;
            color: #94a3b8;
            font-size: 14px;
        }

        .upload-box input[type="file"] {
            display: none;
        }

        .upload-box label {
            display: block;
            cursor: pointer;
            color: #94a3b8;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 24px;
        }

        .btn-cancel,
        .btn-submit {
            padding: 10px 24px;
            font-size: 14px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-cancel {
            background-color: #f1f5f9;
            color: #1e293b;
        }

        .btn-submit {
            background-color: #e42313;
            color: white;
        }

        .btn-submit:hover {
            background-color: #b91c1c;
        }

        .note {
            margin-top: 8px;
            font-size: 12px;
            color: #94a3b8;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('dashboard') }}" class="logo">Telkom Foodies</a>
            <a href="{{ url()->previous() }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <h2>Form Tambah Restaurant</h2>
        <p class="description">Lengkapi Form Berikut untuk Menambahkan Restaurant Baru</p>

        <form action="{{ route('rumah-makan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="nama">Nama Restaurant </label>
                <input type="text" id="nama" name="nama" placeholder="Tuliskan nama Restaurant" required>
            </div>

            <div class="form-group">
                <label for="kategori">Jenis Masakan </label>
                <input type="text" id="kategori" name="kategori" placeholder="Ex: Japanese" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat </label>
                <input type="text" id="alamat" name="alamat" placeholder="Tuliskan Alamat Restaurant" required>
            </div>

            <div class="form-group">
                <label for="jam_buka">Jam Buka</label>
                <div class="time-inputs">
                    <input type="time" id="jam_buka" name="jam_buka">
                    <input type="time" id="jam_tutup" name="jam_tutup">
                </div>
            </div>

            <div class="form-group">
                <label for="kontak">Kontak</label>
                <input type="text" id="kontak" name="kontak" placeholder="Nomor kontak (optional)">
            </div>

            <div class="form-group">
                <label for="foto">Masukkan Foto Restaurant </label>
                <div class="upload-box" onclick="document.getElementById('foto').click();">
                    <input type="file" name="foto" id="foto" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="handleFileUpload(this)">
                    <label for="foto" id="file-label">Choose a file or drag & drop it here</label>
                    <div class="note">JPEG, PNG, and GIF formats, up to 50MB</div>
                </div>
            </div>

            <div class="actions">
                <button type="button" class="btn-cancel" onclick="window.history.back()">Cancel</button>
                <button type="submit" class="btn-submit">Tambah</button>
            </div>
        </form>
    </div>

    <script>
        function handleFileUpload(input) {
            const label = document.getElementById('file-label');
            if (input.files.length > 0) {
                label.textContent = input.files[0].name;
            }
        }
    </script>
</body>
</html>
