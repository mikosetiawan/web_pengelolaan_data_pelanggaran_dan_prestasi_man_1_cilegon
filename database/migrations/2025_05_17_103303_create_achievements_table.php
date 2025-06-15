<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('achievement_type_id')->constrained()->onDelete('restrict');
            $table->string('title');
            $table->date('date');
            $table->string('level')->nullable(); // e.g., school, regional, national
            $table->string('award')->nullable(); // e.g., gold medal, certificate
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};