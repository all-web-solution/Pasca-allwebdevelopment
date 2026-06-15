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
        Schema::create('penelitians', function (Blueprint $table) {
            $table->id();
            $table->string('judul_riset');
            $table->string('penulis');
            $table->string('jurnal_nama'); // Nama jurnal tempat publikasi (e.g., Jurnal sinta 2)
            $table->string('tahun');
            $table->string('link_jurnal')->nullable(); // URL eksternal ke OJS / PDF riset
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penelitians');
    }
};
