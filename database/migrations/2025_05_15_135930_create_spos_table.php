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
        Schema::create('spos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('pelanggaran_id')->constrained('pelanggarans')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('sign_id_waka_siswa')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('sign_id_wali_kelas')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('sign_id_kepala_sekolah')->nullable()->constrained('users')->onDelete('set null');
            $table->string('number_spo')->unique()->nullable();
            $table->date('date_spo');
            $table->time('time_spo');
            $table->string('level_spo'); // 1. ringan 25 > 50 skor pelanggaran siswa (level spo : spo_1), 2. sedang 50 > 75 skor pelanggaran siswa (spo_2),  3. berat 75 > 100 skor siswa (spo_3);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spos');
    }
};