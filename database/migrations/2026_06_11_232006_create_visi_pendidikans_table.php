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
        Schema::create('visi_pendidikans', function (Blueprint $table) {
            $table->id();
            $table->string('judul_visi');
            $table->text('deskripsi_visi');
            $table->string('gambar_visi')->nullable(); // Menyimpan nama file gambar di public/img/
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visi_pendidikans');
    }
};
