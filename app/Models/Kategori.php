<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    // ← TAMBAHKAN INI
    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}