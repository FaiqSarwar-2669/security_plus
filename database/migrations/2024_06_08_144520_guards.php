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
        Schema::create('Guards', function(Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('registrations')->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('First_Name');
            $table->string('Last_Name');
            $table->string('Father_Name');
            $table->string('DOB');
            $table->string('Gender');
            $table->string('Email');
            $table->string('Mobile_Number');
            $table->string('Emergency_Contact');
            $table->string('Address');
            $table->string('City');
            $table->string('Qualification');
            $table->string('Hobbies');
            $table->string('Postal_Code');
            $table->string('Religion');
            $table->string('Category');
            $table->text('Identity');
            $table->string('Password');
            $table->string('Status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Guards');
    }
};
