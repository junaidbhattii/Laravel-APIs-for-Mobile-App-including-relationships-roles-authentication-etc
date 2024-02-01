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
        Schema::create('trips', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->unsignedBigInteger('vehicle_type_id')->nullable();
            $table->unsignedBigInteger('wishlist_of_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            // $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('promo_id')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendor_infos')->onDelete('cascade');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->string('from_place')->nullable();
            $table->string('to_place')->nullable();
            $table->dateTime('from_date')->default(date('Y-m-d h:i:s'))->nullable();
            $table->dateTime('return_date')->default(date('Y-m-d h:i:s'))->nullable();
            $table->decimal('distance', 20,2)->nullable();
            $table->dateTime('created_at')->default(date('Y-m-d h:i:s'))->nullable();
            $table->dateTime('updated_at')->default(date('Y-m-d h:i:s'))->nullable();
            $table->dateTime('created')->default(date('Y-m-d h:i:s'))->nullable();
            $table->dateTime('updated')->default(date('Y-m-d h:i:s'))->nullable();
            $table->integer('people_adult')->nullable();
            $table->integer('people_child')->nullable();
            $table->integer('people_toatal')->nullable();
            $table->integer('total_price')->nullable();
            $table->boolean('booking_status')->default()->nullable();
            $table->boolean('payment_status')->default()->nullable();
            $table->string('paypal_token')->nullable();
            $table->string('stripe_id')->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->boolean('ada_assistance')->default()->nullable();
            $table->decimal('form_lat',11,2)->nullable();
            $table->decimal('from_lng',11,2)->nullable();
            $table->string('ride_share_status')->nullable();
            $table->decimal('to_lat',11,2)->nullable();
            $table->decimal('to_lng',11,2)->nullable();
            $table->decimal('tips',10,2)->nullable();
            $table->string('tips_method')->nullable();
            $table->boolean('tips_status')->default()->nullable();
            $table->boolean('is_scheduled')->default()->nullable();
            // $table->boolean('tips_status')->default()->nullable();
            $table->string('is_schedule_confirmed')->nullable();
            $table->smallInteger('trip_status')->nullable();
            $table->decimal('booking_price',10,2)->nullable();
            // $table->smallInteger('trip_status')->nullable();
            // $table->smallInteger('trip_status')->nullable();
            // $table->smallInteger('trip_status')->nullable();


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
