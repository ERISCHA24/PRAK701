<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('member')->insert([
            [
                'nama_member'        => 'Ahmad Fauzi',
                'nomor_member'       => 'M001',
                'alamat'             => 'Jl. Veteran No. 10, Banjarmasin',
                'tgl_mendaftar'      => now(),
                'tgl_terakhir_bayar' => '2025-12-01',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'nama_member'        => 'Siti Rahmawati',
                'nomor_member'       => 'M002',
                'alamat'             => 'Jl. A. Yani KM 5, Banjarmasin',
                'tgl_mendaftar'      => now(),
                'tgl_terakhir_bayar' => '2025-11-15',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'nama_member'        => 'Budi Santoso',
                'nomor_member'       => 'M003',
                'alamat'             => 'Jl. Lambung Mangkurat No. 3',
                'tgl_mendaftar'      => now(),
                'tgl_terakhir_bayar' => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);
    }
}