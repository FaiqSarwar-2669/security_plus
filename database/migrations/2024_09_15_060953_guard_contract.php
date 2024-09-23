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
        Schema::create('guardContract', function(Blueprint $table){
            $table->id();
            $table->foreignId('Guards_id')->nullable()->references('id')->on('Guards')->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('CompanyId');
            $table->string('CompanyName');
            $table->string('OrganizationId');
            $table->string('OrganizationName');
            $table->string('Name');
            $table->string('Email');
            $table->string('Mobile_Number');
            $table->string('Address');
            $table->string('City');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardContract');
    }
};
