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
        Schema::create('credit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->double('price');
            $table->double('credits');
            $table->string('payment_id')->nullable();
            $table->foreignId('gateway_id')->nullable()->constrained('gateways')->cascadeOnDelete();
            $table->integer('status')->default(1);
            $table->text('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_logs');
    }
};
