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
        Schema::create("registrations", function(Blueprint $table){
            $table->id();
            $table->string('bussiness_fname')->nullable();
            $table->string('bussiness_lname')->nullable();
            $table->string('bussiness_owner');
            $table->string('cnic');
            $table->string('area_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('street_address')->nullable();
            $table->string('city_name')->nullable();
            $table->string('province')->nullable();
            $table->string('bussiness_type');
            $table->string('profile');
            $table->string('front');
            $table->string('back');
            $table->string('certificate');
            $table->string('password');
            $table->string('email')->unique();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
