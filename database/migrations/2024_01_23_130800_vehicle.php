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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('company_name')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('category')->nullable();
            $table->boolean('is_active')->default(0)->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('license_plate_no')->nullable();
            $table->string('year')->nullable();
            $table->boolean('is_delete')->default(0)->nullable();
            $table->string('image_name')->nullable();
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
