<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievement_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Academic, Non-Academic
            $table->timestamps();
        });

        // Seed initial data
        \App\Models\AchievementType::create(['name' => 'Academic']);
        \App\Models\AchievementType::create(['name' => 'Non-Academic']);
    }

    public function down(): void
    {
        Schema::dropIfExists('achievement_types');
    }
};