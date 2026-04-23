<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->string('pengirim');
            $table->string('perihal');
            $table->date('tanggal_surat');
            $table->date('tanggal_terima');
            $table->string('file')->nullable();
            $table->enum('status', ['belum diproses', 'diproses', 'selesai'])->default('belum diproses');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};