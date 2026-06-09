<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'member_id',
        'buku_id',
        'tgl_pinjam',
        'tgl_kembali',
        'status',
    ];

    protected $casts = [
        'tgl_pinjam'  => 'date',
        'tgl_kembali' => 'date',
    ];

    // ─── RELASI ───────────────────────────────────────────────────────────────

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    // ─── COMPUTED STATUS (seperti hitungStatus() di source code library) ──────

    /**
     * Menghitung status tampilan berdasarkan tanggal dan status database.
     * Nilai: 'selesai' | 'overdue' | 'today' | 'aktif'
     */
    public function getDisplayStatusAttribute(): string
    {
        if ($this->status === 'selesai') {
            return 'selesai';
        }

        $today = Carbon::today()->toDateString();
        $tgl   = $this->tgl_kembali instanceof Carbon
                    ? $this->tgl_kembali->toDateString()
                    : (string) $this->tgl_kembali;

        if ($today > $tgl)  return 'overdue';
        if ($today === $tgl) return 'today';

        return 'aktif';
    }
}