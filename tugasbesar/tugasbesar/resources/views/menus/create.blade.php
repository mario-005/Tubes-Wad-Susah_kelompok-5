@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Create Menu</title>

        <!-- Internal CSS -->
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }

            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 30px;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                margin-top: 50px;
            }

            h1 {
                font-size: 2rem;
                color: #333;
                margin-bottom: 20px;
                text-align: center;
            }

            .restaurant-info {
                background-color: #e9ecef;
                padding: 15px;
                border-radius: 5px;
                margin-bottom: 20px;
            }

            .restaurant-info h3 {
                margin: 0;
                color: #495057;
                font-size: 1.2rem;
            }

            .restaurant-info p {
                margin: 5px 0 0;
                color: #6c757d;
            }

            .form-group {
                margin-bottom: 15px;
            }

            label {
                font-weight: bold;
                font-size: 14px;
            }

            .form-control {
                width: 100%;
                padding: 10px;
                margin: 8px 0;
                border-radius: 5px;
                border: 1px solid #ddd;
            }

            .form-control:focus {
                border-color: #007bff;
                box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            }

            textarea.form-control {
                height: 100px;
                resize: vertical;
            }

            select.form-control {
                cursor: pointer;
            }

            button[type="submit"] {
                background-color: #007bff;
                color: white;
                padding: 12px 20px;
                border-radius: 5px;
                text-decoration: none;
                display: inline-block;
                width: auto;  
                text-align: center;
                margin-top: 10px;
                border: none;
                cursor: pointer;
                font-size: 16px;
            }

            button[type="submit"]:hover {
                background-color: #0056b3;
            }

            .btn-back {
                background-color: #6c757d;
                color: white;
                padding: 12px 20px;
                border-radius: 5px;
                text-decoration: none;
                display: inline-block;
                width: auto;
                text-align: center;
                margin-top: 10px;
                margin-left: 10px;
            }

            .btn-back:hover {
                background-color: #5a6268;
            }

            .button-group {
                display: flex;
                justify-content: flex-start;
                align-items: center;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container">
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
                    <input type="file" name="image" id="image" class="form-control" required>
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
                    <button type="submit" class="btn btn-primary">Simpan Menu</button>
                    <a href="{{ route('rumah-makan.show', $rumahMakan->id) }}" class="btn-back">Kembali</a>
                </div>
            </form>
        </div>
    </body>
    </html>
@endsection
