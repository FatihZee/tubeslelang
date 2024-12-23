<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function managedAuctions()
    {
        return $this->hasMany(Auction::class, 'admin_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'user_id');
    }

    public function participatedAuctions()
    {
        return $this->hasManyThrough(
            Auction::class, 
            Bid::class, 
            'user_id',
            'id',
            'id_user',
            'auction_id'
        );
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id_user');
    }
}