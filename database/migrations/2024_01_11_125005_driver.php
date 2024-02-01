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
        Schema::create('driver', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('SelfDriverProfileId')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('SelfDriverProfileId')->references('id')->on('users')->onDelete('cascade');
            // $table->string('roles');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('address')->nullable();
            $table->string('driver_type')->nullable();
            $table->string('email')->unique();
            $table->string('driving_licence_no')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('stripe_id')->nullable();
            $table->boolean('subscription_status')->default(0)->nullable();
            $table->string('subscription_type')->nullable();
            
            $table->timestamp('email_verified_at')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->dateTime('subcription_start_date')->default(date('Y-m-d h:i:s'))->nullable();
            $table->dateTime('subcription_end_date')->default(date('Y-m-d h:i:s'))->nullable();
            $table->boolean('is_online')->default(0)->nullable();
            $table->boolean('is_deleted')->default(0)->nullable();

            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('apple_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
