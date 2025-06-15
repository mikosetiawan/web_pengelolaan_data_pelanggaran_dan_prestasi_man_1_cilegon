<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique();
            $table->string('name');
            $table->string('class');
            $table->enum('gender', ['L', 'P']);
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('status')->default('active'); // Status : active, inactive
            
            // Parent/Guardian Biodata
            $table->string('father_name')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('father_phone')->nullable();
            $table->text('father_address')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('mother_phone')->nullable();
            $table->text('mother_address')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_occupation')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->text('guardian_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};