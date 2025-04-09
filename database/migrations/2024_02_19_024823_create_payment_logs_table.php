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
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('gateway_id')->constrained()->cascadeOnDelete();

            $table->string('order_id')->nullable(); // 15241854
            $table->string('order_uuid')->nullable(); // order-660cdac571534

            $table->string('price_currency')->nullable();
            $table->string('price_amount'); // 10 usd

            $table->string('pay_currency')->nullable();
            $table->string('pay_amount'); // 0.00080845 BTC

            $table->string('receive_currency')->nullable();
            $table->string('receive_amount'); // 9.4

            $table->string('conversion_rate'); // 1 btc to 65823.96 usd

            $table->string('payment_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_logs');
    }
};
