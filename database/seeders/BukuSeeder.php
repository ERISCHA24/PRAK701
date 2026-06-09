<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('buku')->insert([
            ['judul' => 'Negeri Para Bedebah',    'penulis' => 'Tere Liye',      'penerbit' => 'Gramedia',         'tahun_terbit' => 2012, 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Negeri Di Ujung Tanduk', 'penulis' => 'Tere Liye',      'penerbit' => 'Gramedia',         'tahun_terbit' => 2013, 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Bumi',                   'penulis' => 'Tere Liye',      'penerbit' => 'Gramedia',         'tahun_terbit' => 2014, 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Laskar Pelangi',          'penulis' => 'Andrea Hirata',  'penerbit' => 'Bentang Pustaka',  'tahun_terbit' => 2005, 'created_at' => now(), 'updated_at' => now()],
            ['judul' => 'Sang Pemimpi',            'penulis' => 'Andrea Hirata',  'penerbit' => 'Bentang Pustaka',  'tahun_terbit' => 2006, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}