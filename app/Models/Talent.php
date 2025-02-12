<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'profesi',
        'range_harga'
    ];

    protected $hidden = [];
}
