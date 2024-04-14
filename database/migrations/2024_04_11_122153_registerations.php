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
            $table->string('bussiness_fname');
            $table->string('bussiness_lname');
            $table->string('bussiness_owner');
            $table->string('area_code');
            $table->string('phone_number');
            $table->string('street_address');
            $table->string('city_name');
            $table->string('province');
            $table->string('bussiness_type');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('logo')->nullable();
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
