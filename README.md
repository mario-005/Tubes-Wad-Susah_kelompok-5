# Sistem Manajemen Rumah Makan - User Manual

Aplikasi web untuk manajemen rumah makan yang mencakup pengelolaan menu, reservasi ruangan, ulasan, dan status operasional.
---

## Tentang Aplikasi

Sistem Manajemen Rumah Makan adalah aplikasi berbasis web yang dibangun menggunakan Laravel Framework. Aplikasi ini dirancang untuk memudahkan pengelolaan operasional rumah makan, termasuk manajemen menu, reservasi ruangan, ulasan pelanggan, dan pengaturan jam operasional.

**Teknologi yang Digunakan:**
- **Backend**: Laravel 11.x
- **Frontend**: Blade Template, Bootstrap 5
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Sanctum
- **Deployment**: Vercel

---

## Fitur Utama

### Untuk Admin:
- Manajemen Rumah Makan (CRUD)
- Manajemen Menu (tambah, edit, hapus menu)
- Manajemen Ruangan (tambah, edit, hapus ruangan)
- Manajemen Reservasi (lihat, approve, reject)
- Manajemen Ulasan (lihat, hapus ulasan)
- Pengaturan Status Operasional
- Dashboard Admin dengan statistik

### Untuk User:
- Registrasi dan Login
- Melihat Daftar Menu
- Melakukan Reservasi Ruangan
- Memberikan Ulasan
- Melihat Status Operasional Rumah Makan

---

### Admin Default

Setelah menjalankan seeder, Anda dapat login sebagai admin menggunakan kredensial berikut:

```
Email: admin@example.com
Password: password
```

**PENTING:** Segera ubah password default setelah login pertama kali!

##  Panduan Penggunaan

### Untuk Admin

#### 1. Login ke Dashboard Admin

1. Akses aplikasi di browser
2. Klik tombol **Login**
3. Masukkan email dan password admin
4. Anda akan diarahkan ke Dashboard Admin

#### 2. Manajemen Rumah Makan

**Menambah Rumah Makan:**
1. Dari dashboard, pilih menu **Rumah Makan**
2. Klik tombol **Tambah Rumah Makan**
3. Isi form dengan informasi:
   - Nama Rumah Makan
   - Alamat
   - Nomor Telepon
   - Deskripsi
   - Upload gambar (opsional)
4. Klik **Simpan**

**Edit/Hapus Rumah Makan:**
- Klik tombol **Edit** untuk mengubah data
- Klik tombol **Hapus** untuk menghapus (konfirmasi diperlukan)

#### 3. Manajemen Menu

**Menambah Menu:**
1. Pilih menu **Menu**
2. Klik **Tambah Menu**
3. Isi form:
   - Nama Menu
   - Deskripsi
   - Harga
   - Kategori
   - Rumah Makan (pilih dari dropdown)
   - Upload gambar menu
4. Klik **Simpan**

**Edit/Hapus Menu:**
- Gunakan tombol aksi di tabel daftar menu

#### 4. Manajemen Ruangan

**Menambah Ruangan:**
1. Pilih menu **Ruangan**
2. Klik **Tambah Ruangan**
3. Isi informasi:
   - Nama Ruangan
   - Kapasitas
   - Deskripsi
   - Rumah Makan
   - Fasilitas
4. Klik **Simpan**

#### 5. Manajemen Reservasi

**Melihat Reservasi:**
1. Pilih menu **Reservasi**
2. Lihat daftar semua reservasi dengan status

**Approve/Reject Reservasi:**
1. Klik tombol **Detail** pada reservasi
2. Pilih **Approve** untuk menyetujui
3. Pilih **Reject** untuk menolak
4. Tambahkan catatan jika diperlukan

#### 6. Manajemen Ulasan

**Melihat dan Moderasi Ulasan:**
1. Pilih menu **Ulasan**
2. Lihat semua ulasan dari pelanggan
3. Hapus ulasan yang tidak sesuai dengan tombol **Hapus**

#### 7. Pengaturan Status Operasional

**Mengatur Jam Operasional:**
1. Pilih menu **Status Operasional**
2. Pilih rumah makan
3. Atur untuk setiap hari:
   - Status (Buka/Tutup)
   - Jam Buka
   - Jam Tutup
4. Klik **Simpan**

---

### Untuk User

#### 1. Registrasi Akun

1. Klik tombol **Register**
2. Isi form registrasi:
   - Nama Lengkap
   - Email
   - Password
   - Konfirmasi Password
3. Klik **Register**
4. Login dengan kredensial yang telah dibuat

#### 2. Melihat Menu

1. Dari halaman utama, klik **Menu**
2. Browse menu berdasarkan rumah makan
3. Lihat detail menu dengan klik gambar atau nama menu

#### 3. Melakukan Reservasi

**Langkah-langkah Reservasi:**
1. Pilih menu **Reservasi** atau **Ruangan**
2. Pilih rumah makan
3. Pilih ruangan yang tersedia
4. Isi form reservasi:
   - Tanggal reservasi
   - Jam mulai
   - Jam selesai
   - Jumlah orang
   - Catatan khusus (opsional)
5. Klik **Submit Reservasi**
6. Tunggu konfirmasi dari admin

**Melihat Status Reservasi:**
1. Login ke akun Anda
2. Pilih **Reservasi Saya**
3. Lihat status reservasi (Pending/Approved/Rejected)

#### 4. Memberikan Ulasan

**Cara Memberikan Ulasan:**
1. Pilih rumah makan yang ingin diulas
2. Klik **Tulis Ulasan**
3. Isi form:
   - Rating (1-5 bintang)
   - Komentar
4. Klik **Kirim Ulasan**

**Catatan:** 
- Ulasan akan langsung tampil setelah dikirim
- Admin dapat menghapus ulasan yang tidak sesuai

#### 5. Melihat Status Operasional

1. Klik pada rumah makan
2. Lihat **Status Operasional** di halaman detail
3. Cek jam buka dan tutup untuk setiap hari

---
