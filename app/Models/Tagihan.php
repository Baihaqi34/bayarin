<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';

    protected $fillable = [
        'pelanggan_id',
        'nominal',
        'periode',
        'jatuh_tempo',
        'status',
        'dibayar_at',
    ];

    function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
}
