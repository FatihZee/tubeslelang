<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bid_id',
        'nominal',
        'image',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }
}