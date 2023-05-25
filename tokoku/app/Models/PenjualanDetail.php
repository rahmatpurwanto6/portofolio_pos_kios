<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_penjualan',
        'id_user',
        'id_produk',
        'harga_jual',
        'jumlah',
        'total',
        'bayar',
        'kembalian',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id');
    }
}
