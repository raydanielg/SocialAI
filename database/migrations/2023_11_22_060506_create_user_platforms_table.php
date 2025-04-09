<?php

use App\Models\UserPlatform;
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
        Schema::create('user_platforms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('platform_id');
            $table->enum('platform', UserPlatform::PLATFORMS);

            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->text('picture')->nullable();

            $table->text('access_token');
            $table->dateTime('access_token_expire_at')->nullable();

            $table->text('refresh_token')->nullable();
            $table->dateTime('refresh_token_expire_at')->nullable();

            $table->dateTime('failed_mail_send_at')->nullable();
            
            $table->enum('type', ['user', 'page'])->default('user'); // user or page =>
            $table->text('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_platforms');
    }
};
