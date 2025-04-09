<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kyc_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kyc_method_id')->constrained('kyc_methods')->cascadeOnDelete();
            $table->integer('status')->default(0)->comment('0 for pending, 1 for approved, 2 for rejected');
            $table->date('rejected_at')->nullable();
            $table->text('note')->nullable();
            $table->text('comment')->nullable();
            $table->text('data')->nullable();
            $table->text('fields')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kyc_requests');
    }
};
