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
        Schema::create('vendor_infos', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('phone_number')->nullable();

            $table->string('usdot')->nullable();
            $table->string('company_name')->nullable();
            $table->string('mailing_address')->nullable();
            $table->string('company_city')->nullable();
            $table->string('company_state')->nullable();
            $table->string('company_country')->nullable();
            $table->string('company_zipcode')->nullable();
            $table->string('industry_association')->nullable();
            $table->string('amenities')->nullable();
            $table->string('website_url')->nullable();
            $table->string('paypal_email')->nullable();
            $table->string('company_contect_number')->nullable();
            $table->string('no_vehicle')->nullable();
            $table->string('no_drivers')->nullable();
            $table->string('MOTORCOACH')->nullable();
            $table->string('ENTERTAINER_MOTORCOACH')->nullable();
            $table->string('SHUTTLE_BUS')->nullable();
            $table->string('MINI_BUS')->nullable();
            $table->string('PARTY_BUS')->nullable();
            $table->string('SCHOOL_BUS')->nullable();
            $table->string('LAIMOUSINES')->nullable();
            $table->string('SUV')->nullable();
            $table->string('SEDAN')->nullable();
            $table->string('personal_vehicles')->nullable();
            $table->string('TEXIES')->nullable();
            $table->double('latitude')->nullable();
            $table->double('logitude')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('zip_code')->nullable();
            $table->enum('subcription_type',['STARTER','AGENCY','PROFESSIONAL'])->nullable();
            $table->dateTime('subcription_start_date')->default(date('Y-m-d h:i:s'))->nullable();
            $table->dateTime('subcription_end_date')->default(date('Y-m-d h:i:s'))->nullable();
            $table->boolean('phone_varified')->nullable();
            $table->boolean('is_online')->default(0)->nullable();
            $table->boolean('is_deleted')->default(0)->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('apple_id')->nullable();
            $table->string('login_attampts')->default(0)->nullable();
            $table->string('stripe_id')->nullable();
            $table->string('paypal_id')->nullable();
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
        //
    }
};
