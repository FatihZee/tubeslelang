<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Primary key yang digunakan dalam tabel users
    protected $primaryKey = 'id_user';

    // Kolom-kolom yang dapat diisi melalui metode mass assignment
    protected $fillable = [
        'name',       // Nama user
        'email',      // Email user
        'username',   // Username unik
        'password',   // Password hashed
        'role',       // Peran user (contoh: admin atau user biasa)
    ];

    // Kolom yang disembunyikan saat data dikonversi menjadi array atau JSON
    protected $hidden = [
        'password',        // Menyembunyikan password
        'remember_token',  // Token untuk fitur "Remember Me"
    ];

    // Tipe data untuk kolom-kolom tertentu
    protected $casts = [
        'email_verified_at' => 'datetime',  // Kolom email_verified_at diperlakukan sebagai datetime
    ];

    // Relasi dengan model Auction melalui foreign key 'admin_id'
    public function managedAuctions()
    {
        // Satu user (admin) dapat mengelola banyak auction
        return $this->hasMany(Auction::class, 'admin_id');
    }

    // Relasi dengan model Bid melalui foreign key 'user_id'
    public function bids()
    {
        // Satu user dapat memiliki banyak bid
        return $this->hasMany(Bid::class, 'user_id');
    }

    // Relasi melalui (hasManyThrough) dengan model Auction melalui model Bid
    public function participatedAuctions()
    {
        // Satu user dapat berpartisipasi di banyak auction melalui bid
        return $this->hasManyThrough(
            Auction::class,  // Model akhir
            Bid::class,      // Model penghubung
            'user_id',       // Foreign key di Bid yang merujuk ke User
            'id',            // Foreign key di Auction
            'id_user',       // Primary key di User
            'auction_id'     // Foreign key di Bid yang merujuk ke Auction
        );
    }

    // Relasi dengan model Transaction melalui foreign key 'user_id'
    public function transactions()
    {
        // Satu user dapat memiliki banyak transaksi
        return $this->hasMany(Transaction::class, 'user_id', 'id_user');
    }
}
