<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'member';

    protected $fillable = [
        'nama_member',
        'nomor_member',
        'alamat',
        'tgl_mendaftar',
        'tgl_terakhir_bayar',
    ];

    protected $casts = [
        'tgl_mendaftar'      => 'datetime',
        'tgl_terakhir_bayar' => 'date',
    ];

    /**
     * Satu member bisa memiliki banyak peminjaman.
     */
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}