<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('member', function (Blueprint $table) {
            $table->id();                                          // bigint unsigned, auto increment
            $table->string('nama_member', 250);
            $table->string('nomor_member', 15)->unique();
            $table->text('alamat')->nullable();
            $table->timestamp('tgl_mendaftar')->useCurrent();
            $table->date('tgl_terakhir_bayar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};