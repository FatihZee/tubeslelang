<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];    

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];
//
    public function auctions()
    {
        return $this->hasMany(Auction::class, 'product_id');
    }
}