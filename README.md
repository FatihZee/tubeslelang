# README: Website Lelang

## Overview
Selamat datang di repository **Website Lelang**, sebuah platform berbasis web yang dirancang untuk memfasilitasi proses lelang secara daring. Website ini menawarkan pengalaman lelang yang mudah, transparan, dan aman bagi pengguna. Proyek ini dibuat sebagai tugas besar dalam mata kuliah **Web Application Development (WAD)** oleh kelompok:

1. **Fatih Fikry Oktavianto**
2. **Muhammad Ridho Irhamna**
3. **Muhammad Aga Hibatulloh**
4. **Nathania Salsabila**
5. **Deo Nur Febryan**
6. **Ailsya Frederica Aldora**

## Key Features
### 1. **Users (Akun Pengguna)**  
- Fitur registrasi dan login untuk pengguna (penjual dan pembeli).  
- Sistem otentikasi berbasis token untuk keamanan dan privasi data pengguna.  
- Pengelolaan data pengguna seperti nama, email, dan peran.  

### 2. **Products (Manajemen Produk)**  
- Penjual dapat menambahkan produk baru untuk dilelang.  
- Fitur untuk mengedit informasi produk seperti deskripsi, harga, dan gambar.  
- Penghapusan produk yang tidak ingin dilelang lagi.  

### 3. **Auctions (Dashboard Lelang)**  
- Penjual dapat membuat pelelangan untuk produk mereka.  
- Pembeli dapat melihat daftar pelelangan yang sedang berlangsung.  
- Informasi status lelang, seperti waktu berakhir, ditampilkan secara real-time.  

### 4. **Bids (Sistem Penawaran)**  
- Pembeli dapat mengajukan penawaran untuk produk yang dilelang.  
- Validasi otomatis untuk memastikan tawaran lebih tinggi dari penawaran sebelumnya.  
- Riwayat tawaran dapat dilihat oleh penjual dan pembeli terkait.  

### 5. **Transactions (Transaksi)**  
- Setelah pelelangan selesai, sistem secara otomatis membuat transaksi untuk tawaran tertinggi.  
- Penjual dan pembeli dapat melihat detail transaksi, termasuk status pembayaran.  
- Dukungan untuk melacak riwayat transaksi pengguna.  

### 6. **Feedbacks (Ulasan & Masukan)**  
- Pembeli dapat memberikan ulasan untuk produk setelah transaksi selesai.  
- Penjual dapat merespon ulasan untuk membangun kepercayaan.  
- Sistem menyimpan semua feedback untuk membantu meningkatkan kualitas layanan.  

## Technology Stack
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Framework**: Laravel 11 (untuk modularisasi dan kemudahan pengembangan)

## Installation

### Prerequisites
Pastikan Anda memiliki perangkat lunak berikut:
1. **PHP** ≥ 8.3
2. **Composer**
3. **MySQL**
4. **Web Server** seperti Apache atau Nginx
5. **Git**

### Steps
1. Clone repository ini:
   ```bash
   git clone https://github.com/FatihZee/website-lelang.git
   ```

2. Navigasikan ke direktori proyek:
   ```bash
   cd website-lelang
   ```

3. Install dependencies dengan Composer:
   ```bash
   composer install
   ```

4. Konfigurasi file `.env`:
   - Salin file `.env.example` menjadi `.env`
   - Masukkan konfigurasi database Anda:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=website_lelang
     DB_USERNAME=root
     DB_PASSWORD=yourpassword
     ```

5. Jalankan migrasi dan seeding database:
   ```bash
   php artisan migrate --seed
   ```

6. Generate application key:
   ```bash
   php artisan key:generate
   ```

7. Jalankan server lokal:
   ```bash
   php artisan serve
   ```

8. Akses aplikasi melalui browser di `http://localhost:8000`


## Development Team
- **Project Manager**: Ailsya Frederica Aldora
- **Lead Developer**: Muhammad Aga Hibatulloh
- **Backend Developer**: Fatih Fikry Oktavianto
- **Frontend Developer**: Muhammad RIdho Irhamna
- **UI/UX Designer**: Deo Nur Febryan
- **Quality Assurance**: Nathania Salsabila

## License
Proyek ini dilisensikan di bawah MIT License. Silakan lihat file `LICENSE` untuk informasi lebih lanjut.

## Acknowledgements
Terima kasih kepada dosen dan asisten dosen **Web Application Development** atas panduan dan dukungan dalam mengembangkan proyek ini.

---
**Contact Information**  
Untuk pertanyaan lebih lanjut, silakan hubungi tim pengembang melalui email: **kelompokWAD2023@example.com**" > README.md