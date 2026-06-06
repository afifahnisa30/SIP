<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kategori',
        'harga_dasar',
        'image',
        'ukuran_standar',
        'deskripsi',
    ];  
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori', 'nama');
    }
}

