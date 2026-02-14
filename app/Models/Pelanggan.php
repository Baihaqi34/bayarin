<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $fillable = [
        'nama',
        'nomor',
        'alamat',
        'id_paket',
        'tagihan',
        'tanggal_bayar',
        'status',
    ];

    function paket()
    {
        return $this->hasOne(Paket::class, 'id', 'id_paket');
    }
}
