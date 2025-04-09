<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('brand_post_platforms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_platform_id')->nullable()->constrained()->nullOnDelete();

            // contents
            $table->string('platform')->nullable();
            $table->text('content')->nullable();

            $table->enum('media_type', ['image', 'video'])->nullable();
            $table->longText('media')->nullable();

            // analytics  status => published 
            $table->string('thumbnail')->nullable();
            $table->string('post_id')->nullable();
            $table->integer('reactions')->default(0);
            $table->integer('comments')->default(0);

            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'publishing', 'published', 'failed'])->default('draft');
            $table->longText('data')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_post_platforms');
    }
};
