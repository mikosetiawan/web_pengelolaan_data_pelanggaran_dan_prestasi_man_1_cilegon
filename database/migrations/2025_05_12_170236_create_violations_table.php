<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggaran');
            $table->unsignedInteger('skor'); // Gunakan unsignedInteger untuk konsistensi
            $table->enum('kategori', ['ringan', 'sedang', 'berat'])->nullable(); // Batasi kategori ke ringan, sedang, berat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};