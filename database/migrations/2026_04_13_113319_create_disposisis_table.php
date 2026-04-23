<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_masuk_id')->nullable()->constrained('surat_masuk')->onDelete('cascade');
            $table->foreignId('surat_keluar_id')->nullable()->constrained('surat_keluar')->onDelete('cascade');
            $table->foreignId('dari_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kepada_user_id')->constrained('users')->onDelete('cascade');
            $table->text('isi');
            $table->date('tanggal');
            $table->enum('status', ['baru', 'proses', 'selesai'])->default('baru');
            $table->timestamps();

            // Index untuk query cepat
            $table->index(['kepada_user_id', 'dari_user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('disposisi');
    }
};