<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori'];

    public function produk()
    {
        return $this->hasOne('App\Models\Produk', 'id_kategori');
    }
}
