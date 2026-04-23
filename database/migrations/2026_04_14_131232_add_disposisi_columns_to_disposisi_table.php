<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            // Tambahkan kolom yang masih kurang
            if (!Schema::hasColumn('disposisi', 'instruksi')) {
                $table->text('instruksi');
            }

            if (!Schema::hasColumn('disposisi', 'batas_waktu')) {
                $table->date('batas_waktu')->nullable();
            }

            if (!Schema::hasColumn('disposisi', 'catatan')) {
                $table->text('catatan')->nullable();
            }

            if (!Schema::hasColumn('disposisi', 'status')) {
                $table->string('status')->default('belum dibaca');
            }

            // Index untuk performa
            $table->index('status');
            $table->index('batas_waktu');
        });
    }

    public function down(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            $table->dropColumn(['instruksi', 'batas_waktu', 'catatan', 'status']);
        });
    }
};