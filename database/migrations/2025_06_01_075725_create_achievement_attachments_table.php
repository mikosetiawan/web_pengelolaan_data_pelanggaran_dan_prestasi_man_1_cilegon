<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchievementAttachmentsTable extends Migration
{
    public function up()
    {
        Schema::create('achievement_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('achievement_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('achievement_attachments');
    }
}