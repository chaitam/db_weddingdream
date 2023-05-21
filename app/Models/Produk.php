<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'harga',
        'nama_produk',
        'desc_produk',
        'foto_produk',
        'rating',
        'ulasan',
        'file_cover'
    ];

    protected $hidden = [];

}
