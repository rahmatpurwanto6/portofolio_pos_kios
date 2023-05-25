<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_produk',
        'jumlah',
        'bayar',
        'kembalian',
    ];

    public function penjualan_detail()
    {
        return $this->hasMany(PenjualanDetail::class, 'id_penjualan');
    }
}
