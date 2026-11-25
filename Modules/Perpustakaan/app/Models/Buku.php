<?php

namespace Modules\Perpustakaan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku'; // Menyesuaikan dengan nama tabel migration kita

    protected $fillable = [
        'kode_buku',
        'judul',
        'penulis',
        'kategori',
        'stok',
    ];
}