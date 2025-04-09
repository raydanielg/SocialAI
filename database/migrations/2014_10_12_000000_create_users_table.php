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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->nullable()->unique();
            $table->string('avatar')->nullable();
            $table->string('role')->default('user');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->double('credits')->default(0);
            $table->text('meta')->nullable();
            $table->integer('status')->default(1);
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->longText('plan_data')->nullable();
            $table->integer('plan_id')->nullable()->constrained();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('kyc_verified_at')->nullable();
            $table->date('will_expire')->nullable();
            $table->string('password')->nullable();;
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
