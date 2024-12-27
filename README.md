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
- **Akun Pengguna**: Registrasi dan login untuk penjual dan pembeli.
- **Dashboard Pengguna**: Tinjauan aktivitas lelang, termasuk produk yang dilelang atau ditawar.
- **Manajemen Produk**: Penjual dapat menambahkan, mengedit, dan menghapus produk yang dilelang.
- **Sistem Penawaran**: Pembeli dapat mengajukan penawaran untuk produk yang diinginkan.
- **Notifikasi**: Notifikasi real-time untuk perubahan status lelang.
- **Keamanan**: Sistem otentikasi berbasis token untuk menjaga privasi dan keamanan data pengguna.

## Technology Stack
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Framework**: Laravel 8 (untuk modularisasi dan kemudahan pengembangan)

## Installation

### Prerequisites
Pastikan Anda memiliki perangkat lunak berikut:
1. **PHP** ≥ 7.4
2. **Composer**
3. **MySQL**
4. **Web Server** seperti Apache atau Nginx
5. **Git**

### Steps
1. Clone repository ini:
   ```bash
   git clone https://github.com/[username]/website-lelang.git
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