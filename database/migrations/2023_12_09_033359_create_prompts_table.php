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
        Schema::create('prompts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('prompt');
            $table->enum('type', ['content', 'brand']);
            $table->string('prompt_type');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->integer('max_token')->nullable();
            $table->decimal('credit_charge', 8, 2)->default(0);
            $table->longText('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompts');
    }
};
