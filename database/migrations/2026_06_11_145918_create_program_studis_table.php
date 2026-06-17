<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('program_studis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            // INI FIELD BARU NYA GW SELIPIN DI SINI
            $table->string('slug')->unique()->nullable();

            $table->string('icon')->default('fa-graduation-cap');
            $table->string('search_tags');
            $table->text('deskripsi');

            // INI FIELD UNTUK HALAMAN DETAIL PRODI-NYA
            $table->longText('profil')->nullable();
            $table->longText('visi_misi')->nullable();
            $table->longText('kurikulum')->nullable();
            $table->longText('dosen')->nullable();
            $table->longText('dokumen')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_studis');
    }
};
