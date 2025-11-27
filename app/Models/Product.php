<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // PENTING: Kita izinkan semua kolom ini diisi
    protected $fillable = [
        'name',
        'sku',          // <-- Pastikan ini ada
        'price',
        'stock',
        'image',        // <-- Pastikan ini 'image' (sesuai database temanmu), bukan 'image_path'
        'sizes',        // <-- Kolom baru
        'tags',         // <-- Kolom baru
        'rating',       // <-- Kolom baru
        'description',  // <-- Kolom baru
    ];
}