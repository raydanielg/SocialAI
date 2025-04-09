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
        Schema::create('ai_video_options', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('provider');
            $table->string('model');
            $table->string('title');
            $table->string('version')->default('v1');
            $table->longText('meta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_video_options');
    }
};
