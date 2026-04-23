<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('disposisi', function (Blueprint $table) {
            $table->foreignId('dari_user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->after('surat_keluar_id');

            $table->foreignId('kepada_user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->after('dari_user_id');

            // Index agar query cepat
            $table->index(['kepada_user_id', 'dari_user_id']);
        });
    }

    public function down()
    {
        Schema::table('disposisi', function (Blueprint $table) {
            $table->dropForeign(['dari_user_id']);
            $table->dropForeign(['kepada_user_id']);
            $table->dropColumn(['dari_user_id', 'kepada_user_id']);
        });
    }
};