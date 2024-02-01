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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->enum('subcription_type',['STARTER','AGENCY','PROFESSIONAL'])->nullable();
            $table->dateTime('subcription_start_date')->default(date('Y-m-d h:i:s'))->nullable();
            $table->dateTime('subcription_end_date')->default(date('Y-m-d h:i:s'))->nullable();
            $table->boolean('phone_varified')->nullable();
            $table->boolean('is_online')->default(0)->nullable();
            $table->boolean('is_deleted')->default(0)->nullable();
            $table->string('phone_number')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('apple_id')->nullable();
            $table->string('login_attampts')->default(0)->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->longText('profile_picture')->nullable();
            $table->string('roles');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
