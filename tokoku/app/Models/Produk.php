<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'merk',
        'harga_beli',
        'harga_jual',
        'stok',
        'diskon',
        'id_kategori'
    ];

    public function kategori()
    {
        return $this->belongsTo('App\Models\Kategori', 'id');
    }
}
